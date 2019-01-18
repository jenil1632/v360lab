<?php
try {
  if($_SERVER["REQUEST_METHOD"] == "POST")
  {
  $user_name = trim(filter_input(INPUT_POST,"user_name",FILTER_SANITIZE_STRING));
  $user_password = trim(filter_input(INPUT_POST,"user_password",FILTER_SANITIZE_STRING));
  $company_name = trim(filter_input(INPUT_POST,"company_name",FILTER_SANITIZE_STRING));
  $mobile_number = trim(filter_input(INPUT_POST,"mobile_number",FILTER_SANITIZE_STRING));
  if ($user_name == "" || $user_password == "" || $company_name == "" || $mobile_number == "" || strpos($user_name, "/")===true || strpos($user_name, "\\")===true || strpos($user_name, ":")===true || strpos($user_name, "*")===true || strpos($user_name, "?")===true || strpos($user_name, '\"')===true || strpos($user_name, "<")===true || strpos($user_name, ">")===true || strpos($user_name, "|")===true || strpos($user_name, " ")===true) {
        header('location: http://www.bawbaw.co/hosting/v360lab/signup.php?page=error');
        exit();
    }
  include 'connection.php';
  $response = $db->prepare("INSERT INTO user (user_name, user_password, mobile_number, company_name) VALUES(?, ?, ?, ?)");
  $response->bindParam(1, $user_name, PDO::PARAM_STR);
  //$hashed = password_hash($user_password, PASSWORD_DEFAULT);
  //$response->bindParam(2, $hashed, PDO::PARAM_STR);
  $response->bindParam(2, $user_password, PDO::PARAM_STR);
  $response->bindParam(3, $mobile_number, PDO::PARAM_STR);
  $response->bindParam(4, $company_name, PDO::PARAM_STR);
  $response->execute();
  if($response->rowCount()>0)
  {
    $response = $db->prepare("INSERT INTO user_info (user_name) VALUES(?)");
    $response->bindParam(1, $user_name, PDO::PARAM_STR);
    $response->execute();
    $response = $db->prepare("INSERT INTO user_products (user_name) VALUES(?)");
    $response->bindParam(1, $user_name, PDO::PARAM_STR);
    $response->execute();
    require_once __DIR__ . '/functions.php';
    createDir($user_name);
    createCookie($user_name);
    header("location: http://www.bawbaw.co/hosting/v360lab/edit.php?user_name=$user_name");
    exit;
  }
}
} catch (\Exception $e) {
echo "Unable to Connect";
}
 ?>
