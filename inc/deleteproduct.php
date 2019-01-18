<?php
 try {
  if($_SERVER["REQUEST_METHOD"] == "GET")
  {
   $delete_array = json_decode($_GET['arr']);
  $user_name = $_GET['user_name'];
   if($user_name == "") {
         header("location: http://www.bawbaw.co/hosting/v360lab/login.php");
         exit();
   }
  include 'connection.php';
  $response = $db->prepare("SELECT product_list FROM user_products WHERE user_name = ?");
  $response->bindParam(1, $user_name, PDO::PARAM_STR);
  $response->execute();
  $results = $response->fetch();
  $product_array = json_decode($results['product_list']);
  foreach($delete_array->arr as $value)
  {
    for($i = 0;$i<count($product_array);$i++) {print_r($delete_array->arr);
      if($product_array[$i]->product_name==$value)
      {
        unset($product_array[$i]);
        break;
      }
    }
    $product_array = array_values($product_array);
  }
  $product_db = json_encode($product_array);
  $response = $db->query("UPDATE user_products SET product_list = '$product_db' WHERE user_name = '$user_name'");
  $response->execute();
  foreach ($delete_array->arr as $value) {
    $target_dir = __DIR__.'/../uploads/'.$user_name.'/'.$value;
    if (is_dir($target_dir)) {
      array_map('unlink', glob("$target_dir/*.*"));
      rmdir($target_dir);
    }
  }
}
} catch (\Exception $e) {
 echo "Unable to Connect";
}
 ?>
