<?php
 try {
  if($_SERVER["REQUEST_METHOD"] == "POST")
  {
  $product_name = trim(filter_input(INPUT_POST,"product_name",FILTER_SANITIZE_STRING));
  $photonumber = $_POST["photonumber"];
  $imageaspectratio = $_POST["imageaspectratio"];
  $imagefiletype = $_POST["imagefiletype"];
  $user_name = $_GET['user_name'];
  $oldproduct_name = $_GET['oldproduct_name'];
  $product_description= trim(filter_input(INPUT_POST,"product_description",FILTER_SANITIZE_STRING));
  $target_dir = __DIR__.'/../uploads/'.$user_name.'/'.$product_name;
  $replace = false;
  if ($product_name == "" || $product_description == "" || strpos($product_name, "/")===true || strpos($product_name, "\\")===true || strpos($product_name, ":")===true || strpos($product_name, "*")===true || strpos($product_name, "?")===true || strpos($product_name, '\"')===true || strpos($product_name, "<")===true || strpos($product_name, ">")===true || strpos($product_name, "|")===true) {
        header("location: http://www.bawbaw.co/hosting/v360lab/album.php?page=error&user_name=$user_name");
        exit();
    }
    if($oldproduct_name!==$product_name)
    {
      $deletedir = __DIR__.'/../uploads/'.$user_name.'/'.$oldproduct_name;
      rename($deletedir, $target_dir);
      $target_file = $target_dir. '/img_72.' . $imagefiletype;
      $replace = true;
    }
  if (!file_exists($target_dir) && !is_dir($target_dir)) {
    mkdir($target_dir);
  }
  if(isset($_FILES['product_image']))
  {
    $i = 1;
  foreach($_FILES['product_image']['tmp_name'] as $key => $tmp_name)
   {
     $target_file = $target_dir .'/'. basename($_FILES["product_image"]["name"][$key]);
     $info = getimagesize($_FILES['product_image']['tmp_name'][$key]);
     $target_file = $target_dir . '/img_'.$i.'.'.$imagefiletype;
     $i++;
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
             move_uploaded_file($_FILES['product_image']['tmp_name'][$key], $target_file);
   }
 }
 if(isset($target_file)== false)
 {
     $target_file = $target_dir. '/img_72.' . $imagefiletype;
 }
  $target_file = strstr($target_file, 'uploads');
  include 'connection.php';
  $myObj->product_name = $product_name;
  $myObj->product_image = $target_file;
  $myObj->photonumber = $photonumber;
  $myObj->imageaspectratio = $imageaspectratio;
  $myObj->product_description = $product_description;
  $myObj->imagefiletype = $imagefiletype;
  if($oldproduct_name=='')
  {
    $myObj->startDate = date('Y/m/d');
    $myObj->endDate = date('Y/m/d', strtotime('+2 years'));
  }
  $response = $db->prepare("SELECT product_list FROM user_products WHERE user_name = ?");
  $response->bindParam(1, $user_name, PDO::PARAM_STR);
  $response->execute();
  $results = $response->fetch();
  $product_array = json_decode($results['product_list']);
  $productno = count($product_array);
  if($product_array)
  {
    for($i = 0;$i<$productno;$i++) {
      $value = $product_array[$i];
      if($value->product_name == $product_name && $oldproduct_name=='')
      {
        header("location: http://www.bawbaw.co/hosting/v360lab/album.php?product=exists&user_name=$user_name");
        exit;
      }
      if($value->product_name == $product_name && $replace==true)
      {
        header("location: http://www.bawbaw.co/hosting/v360lab/album.php?product=exists&user_name=$user_name");
        exit;
      }
      if($replace==false && $value->product_name==$oldproduct_name)
      {
        $myObj->startDate = $value->startDate;
        $myObj->endDate = $value->endDate;
        array_splice($product_array, $i);
      }
    }
    array_push($product_array, $myObj);
     $product_db = json_encode($product_array);
     $response = $db->query("UPDATE user_products SET product_list = '$product_db' WHERE user_name = '$user_name'");
     $response->execute();
  }
  else {
    $product_array = array($myObj);
    $product_db = json_encode($product_array);
    $response = $db->query("UPDATE user_products SET product_list = '$product_db' WHERE user_name = '$user_name'");
    $response->execute();
 }
 //header("location: http://localhost/album.php?user_name=$user_name");
}
} catch (\Exception $e) {
 echo "Unable to Connect";
}
 ?>
