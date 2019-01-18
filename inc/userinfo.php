<?php
try {
  if($_SERVER["REQUEST_METHOD"] == "POST")
  {
  $full_name = trim(filter_input(INPUT_POST,"full_name",FILTER_SANITIZE_STRING));
  $email_id = trim(filter_input(INPUT_POST,"email_id",FILTER_SANITIZE_EMAIL));
  $company_name = trim(filter_input(INPUT_POST,"company_name",FILTER_SANITIZE_STRING));
  $mobile_number = trim(filter_input(INPUT_POST,"mobile_number",FILTER_SANITIZE_STRING));
  $user_password = trim(filter_input(INPUT_POST,"user_password",FILTER_SANITIZE_STRING));
  $confirm_password = trim(filter_input(INPUT_POST,"confirm_password",FILTER_SANITIZE_STRING));
  $address_line1 = trim(filter_input(INPUT_POST,"address_line1",FILTER_SANITIZE_STRING));
  $address_line2= trim(filter_input(INPUT_POST,"address_line2",FILTER_SANITIZE_STRING));
  $state = $_POST["state"];
  $city = $_POST["city"];
  $user_name = $_GET['user_name'];
  $pincode= trim(filter_input(INPUT_POST,"pincode",FILTER_SANITIZE_NUMBER_INT));
  $target_dir = __DIR__.'/../uploads/'.$user_name;
  if(is_uploaded_file($_FILES['logo_image']['tmp_name']))
  {
    $target_file = $target_dir .'/'. basename($_FILES["logo_image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $info = getimagesize($_FILES['logo_image']['tmp_name']);
    $target_file = $target_dir . '/logo.'. $imageFileType;
    if ($info === FALSE) {
       die("Unable to determine image type of uploaded file");
    }
    if (($info[2] !== IMAGETYPE_JPEG) && ($info[2] !== IMAGETYPE_PNG)) {
   die("Not a jpeg/png");
    }
    if(file_exists($target_file))
    {
      unlink($target_file);
    }
    move_uploaded_file($_FILES['logo_image']['tmp_name'], $target_file);
  }
  if ($full_name == "" || $email_id == "" || $address_line1 == "" || $address_line2 == "" || $pincode =="" || strlen($user_password)<7 || $user_password!==$confirm_password) {
        header("location: http://www.bawbaw.co/hosting/v360lab/edit.php?page=error&user_name=$user_name");
        exit();
    }
  include 'connection.php';
  if($user_password!=='##########')
  {
    //$hashed = password_hash($user_password, PASSWORD_DEFAULT);
    $response = $db->query("UPDATE user SET user_password = '$user_password' WHERE user_name = '$user_name'");
    $response.execute();
  }
  $response = $db->prepare("UPDATE user SET mobile_number = ?, company_name = ? WHERE user_name = ?");
  $response->bindParam(1, $mobile_number, PDO::PARAM_STR);
  $response->bindParam(2, $company_name, PDO::PARAM_STR);
  $response->bindParam(3, $user_name, PDO::PARAM_STR);
  $response->execute();
  $response = $db->prepare("UPDATE user_info SET full_name = ?, email_id = ?, address_line1 = ?, address_line2 = ?, state = ?, city = ?, pincode = ?, logo_image = ? WHERE user_name = ?");
  $response->bindParam(1, $full_name, PDO::PARAM_STR);
  $response->bindParam(2, $email_id, PDO::PARAM_STR);
  $response->bindParam(3, $address_line1, PDO::PARAM_STR);
  $response->bindParam(4, $address_line2, PDO::PARAM_STR);
  $response->bindParam(5, $state, PDO::PARAM_STR);
  $response->bindParam(6, $city, PDO::PARAM_STR);
  $response->bindParam(7, $pincode, PDO::PARAM_INT);
  $response->bindParam(8, $target_file, PDO::PARAM_STR);
  $response->bindParam(9, $user_name, PDO::PARAM_STR);
  $response->execute();
  if($response->rowCount()>0)
  {
    $response = $db->query("UPDATE user_info SET all_filled = 1 WHERE user_name = '$user_name'");
    $response->execute();
    header("location: http://www.bawbaw.co/hosting/v360lab/account.php?user_name=$user_name");
    exit;
  }
}
} catch (\Exception $e) {
echo "Unable to Connect";
}
 ?>
