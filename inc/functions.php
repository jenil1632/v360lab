<?php
   function createjwt($user_name)
   {
     try{
     $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
     $payload = json_encode(['sub' => $user_name]);
     $base64URLheader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
     $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));
     $signature = hash_hmac('sha256', $base64URLheader . "." . $base64UrlPayload, 'khushilazybones80!', true);
     $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));
     $jwt = $base64URLheader . "." . $base64UrlPayload . "." . $base64UrlSignature;
     return $jwt;
   }
   catch(\Exception $e)
   {
     echo $e->getMessage();
   }
   }

   function createCookie($user_name)
   {
     setcookie('v360duser', createjwt($user_name), time()+7200, "/");
   }

   function verifyJWT($algo, $jwt)
   {
    list($headerEncoded, $payloadEncoded, $signatureEncoded) = explode('.', $jwt);
    $dataEncoded = "$headerEncoded.$payloadEncoded";
    $signature = base64url_decode($signatureEncoded);
    $rawSignature = hash_hmac($algo, $dataEncoded, 'khushilazybones80!', true);
    return hash_equals($rawSignature, $signature);
   }

   function base64url_decode($data) {
     return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) + (strlen($data) % 4), '=', STR_PAD_RIGHT));
    }

    function returnusername($jwt){
      list($headerEncoded, $payloadEncoded, $signatureEncoded) = explode('.', $jwt);
      $payload = base64url_decode($payloadEncoded);
      $jsonObj = json_decode($payload, true);
      return $jsonObj['sub'];
    }

    function createDir($user_name)
    {
      $dir = __DIR__ .'/../uploads/'. $user_name;
      return mkdir($dir);
    }

    function hash_equals($str1, $str2) {
  if(strlen($str1) != strlen($str2)) {
    return false;
  } else {
    $res = $str1 ^ $str2;
    $ret = 0;
    for($i = strlen($res) - 1; $i >= 0; $i--) $ret |= ord($res[$i]);
    return !$ret;
  }
}

?>
