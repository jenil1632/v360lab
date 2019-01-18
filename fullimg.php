<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
require_once __DIR__ . '/inc/connection.php';
if(isset($_GET['user_name']))
{
	$user_name = $_GET['user_name']; ;
	$product_image = $_GET['product_image'];
	$photonumber = $_GET['photonumber'];
	$imagefiletype = $_GET['imagefiletype'];
	$product_name = $_GET['product_name'];
	}
	$product_image = 'uploads/'.$user_name.'/'.$product_name.'/img_1.jpg'
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>V360&deg; Lab</title>
	<meta name="description" content="">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/normalize.css">
	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
		<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <style>
  body{ margin:0; padding:0; border:0;}
  #image-container{ margin: 0;padding: 0;border: 0; width: 100%; height: auto;}
  #image360{
    display: block;
    margin: 0 auto;
    max-width: 100%;
  }
  </style>
</head>
<body>
	<div id="image-container">
	<img src="<?php echo $product_image;?>" id="image360">
</div>
<form style="display: none">
	<input type = "text" id = "photonumber" value="<?php echo $photonumber;?>"/>
	<input type = "text" id = "imagefiletype" value = "<?php echo $imagefiletype;?>"/>
	<input type = "text" id = "productimage" value = "<?php echo $product_image;?>"/>
</form>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="app.js"></script>
</body>
</html>
