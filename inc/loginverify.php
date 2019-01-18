<?php
try {
     include 'connection.php';
     $user_name = trim(filter_input(INPUT_POST,"user_name",FILTER_SANITIZE_STRING));
     $user_password = trim(filter_input(INPUT_POST,"user_password",FILTER_SANITIZE_STRING));
     if ($user_name == "" || $user_password == "") {
           $error_message = "Please fill in the valid entries in the required fields.";
           echo "<script>alert($error_message)</script>";
           header('location: http://www.bawbaw.co/hosting/v360lab/login.php?page=error');
           exit();
       }
     $response = $db->prepare("SELECT user_password FROM user WHERE user_name = ?");
     $response->bindParam(1, $user_name, PDO::PARAM_STR);
     $response->execute();
     $results = $response->fetch(PDO::FETCH_ASSOC);
     if($results && $user_password===$results['user_password'])
     {
       require_once __DIR__ . '/functions.php';
       createCookie($user_name);
       header("location: http://www.bawbaw.co/hosting/v360lab/album.php?user_name=$user_name");
       exit;
     }
     else {
       header('location: http://www.bawbaw.co/hosting/v360lab/login.php?page=error');
       exit();
     }
} catch (\Exception $e) {
echo "Unable to Connect";
}
?>
