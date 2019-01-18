<?php header('Access-Control-Allow-Origin: http://www.bawbaw.co/hosting/v360lab/login.php');
$user_name = $_POST["user_name"];
$query = "SELECT user_name FROM user WHERE user_name = ?";
include 'connection.php';
$response = $db->prepare($query);
$response->bindParam(1, $user_name, PDO::PARAM_STR);
$response->execute();
$results = $response->fetch();
if(empty($results))
{
  echo 'valid';
}
else {
  echo "invalid";
}
 ?>
