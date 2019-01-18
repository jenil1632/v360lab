<?php
try {
  if($_SERVER["REQUEST_METHOD"] == "POST")
  {
  $email_id = trim(filter_input(INPUT_POST,"email_id",FILTER_SANITIZE_EMAIL));
  if($email_id == "") {
        header("location: http://www.bawbaw.co/hosting/v360lab/login.php");
        exit();
    }
  include 'connection.php';
  $response = $db->prepare("SELECT user_name FROM  user_info WHERE email_id = ?");
  $response->bindParam(1, $email_id, PDO::PARAM_STR);
  $response->execute();
  $results = $response->fetch(PDO::FETCH_ASSOC);
  if($results['user_name']=='')
  {
    header("location: http://www.bawbaw.co/hosting/v360lab/login.php");
    exit;
  }
  $user_name = $results['user_name'];
  $response = $db->prepare("SELECT user_password FROM user WHERE user_name = ?");
  $response->bindParam(1, $user_name, PDO::PARAM_STR);
  $response->execute();
  $results = $response->fetch(PDO::FETCH_ASSOC);
  $user_password = $results['user_password'];
  $message = "Dear $user_name, \n Your login password is given below. Please keep it a secret! \n Login Password: $user_password \n. This is a system generated mail. Please don't reply to it.";
  mail($email_id, "V360lab forgot password", $message);
  header('location: http://www.bawbaw.co/hosting/v360lab/login.php');
  exit;
}
} catch (\Exception $e) {
echo "Unable to Connect";
}
 ?>
