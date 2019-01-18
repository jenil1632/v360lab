<?php
require_once __DIR__ . '/inc/connection.php';
if(isset($_GET['user_name']) && isset($_GET['product_name']))
{
	$user_name = $_GET['user_name']; ;
	$product_name = $_GET['product_name'];
	$response = $db->query("SELECT product_list FROM user_products WHERE user_name = '$user_name'");
	$results = $response->fetch(PDO::FETCH_ASSOC);
	$obj = json_decode($results['product_list']);
	foreach ($obj as $value) {
		if($value->product_name==$product_name)
		{
			$product_image = $value->product_image;
			$photonumber = $value->photonumber;
			$imageaspectratio = $value->imageaspectratio;
			$imagefiletype = $value->imagefiletype;
			break;
       }
		}
		if($imageaspectratio=='16:9')
		{
			$iwidth = '800px';
			$iheight = '474px';
		}
		else if($imageaspectratio=='4:3')
		{
			$iwidth = '600px';
			$iheight = '474px';
		}
		else if($imageaspectratio=='3:2')
		{
			$iwidth = '600px';
			$iheight = '424px';
		}
		else if($imageaspectratio=='2:3')
		{
			$iwidth = '400px';
			$iheight = '624px';
		}
		else if($imageaspectratio=='3:4')
		{
			$iwidth = '450px';
			$iheight = '624px';
		}
		else if($imageaspectratio=='1:1')
		{
			$iwidth = '500px';
			$iheight = '524px';
		}
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
 	<link rel="stylesheet" href="css/base.css">
 	<link rel="stylesheet" href="css/flexbox.css">
  <style>
  body, html{ margin:0; padding:0; border:0;}
  #image-container{ margin: 0;padding: 0;border: 0}
  #image360{
    display: block;
    margin: 0 auto;
    max-width: 100%;
  }
  #action-bar{
    margin-top: 0;
  }
  </style>
 </head>
 <body>
   <div id = 'rotator' style="width: <?php echo $iwidth;?>; height: <?php echo $iheight;?>">
   <div id="image-container" >
   <img src="<?php echo $product_image;?>" id="image360">
   <i class="material-icons" id="close" style="cursor:pointer">highlight_off</i>
   <img src="img/res/loading.gif" id = "loading">
  </div>
  <div id="action-bar">
   <i class="material-icons" id="leftButton" style="cursor:pointer">chevron_left</i>
   <i class="material-icons" id="play" style="cursor:pointer">play_circle_filled</i>
   <i class="material-icons" id="rightButton" style="cursor:pointer">chevron_right</i>
   <i class="material-icons" id="fullscreen" style="cursor:pointer">fullscreen</i>
  </div>
</div>
 <form style="display: none">
 	<input type = "text" id = "photonumber" value="<?php echo $photonumber;?>"/>
 	<input type = "text" id = "imageaspectratio" value = "<?php echo $imageaspectratio;?>"/>
 	<input type = "text" id = "imagefiletype" value = "<?php echo $imagefiletype;?>"/>
 	<input type = "text" id = "productimage" value = "<?php echo $product_image;?>"/>
 	<input type = "text" id = "user_name" value = "<?php echo $user_name;?>"/>
 	<input type = "text" id = "product_name" value = "<?php echo $product_name;?>"/>
 </form>
 <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
 <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script type="text/javascript" src="app.js"></script>
  </body>
  </html>
