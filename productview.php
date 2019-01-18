<?php
require_once __DIR__ . '/inc/connection.php';
require_once __DIR__ . '/inc/functions.php';
if(isset($_GET['user_name']) && isset($_GET['product_name']))
{
	$user_name = $_GET['user_name']; ;
	$product_name = $_GET['product_name'];
	$response = $db->query("SELECT product_list FROM user_products WHERE user_name = '$user_name'");
	$results = $response->fetch(PDO::FETCH_ASSOC);
	$obj = json_decode($results['product_list']);
	$response = $db->query("SELECT company_name FROM user WHERE user_name = '$user_name'");
	$results = $response->fetch(PDO::FETCH_ASSOC);
	$company_name = $results['company_name'];
	foreach ($obj as $value) {
		if($value->product_name==$product_name)
		{
			$product_image = $value->product_image;
			$photonumber = $value->photonumber;
			$imageaspectratio = $value->imageaspectratio;
			$product_description = $value->product_description;
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
	$product_image = 'uploads/'.$user_name.'/'.$product_name.'/img_1.jpg';
	$url = 'http://www.bawbaw.co/hosting/v360lab/productview.php/user_name='.$user_name.'&product_name='.$product_name;
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
</head>
<body>
	<header class="main-header">
		<div class="top-bar">
		<h5 class="name"><a href="index.html">V360&deg; LAB</a></h5>
		<ul class="nav">
			<li><a href="http://www.bawbaw.co/hosting/v360lab/album.php?user_name=<?php echo htmlspecialchars($user_name);?>">My Album</a></li>
			<li><a href="#">Pricing</a></li>
			<li><a href="#">FAQ's</a></li>
			<?php if(isset($_COOKIE['v360duser']))
				{
					$value = $_COOKIE['v360duser'];
					if((verifyJWT('sha256', $value))==true)
					{
						echo "<li><a href='http://www.bawbaw.co/hosting/v360lab/inc/signout.php?'>Sign Out</a></li>";
					}
					else {
						echo '<li><a href="http://www.bawbaw.co/hosting/v360lab/login.php">Log in</a></li>';
					}
				}
				else {
					echo '<li><a href="http://www.bawbaw.co/hosting/v360lab/login.php">Log in</a></li>';
				}?>
		</ul>
		<h5 class="dropdown-menu">MENU</h5>
		<i class="material-icons" id = "dropdown-arrow">keyboard_arrow_down</i>
	</div>
	<div id = "mobile-nav">
	<ul style="padding-left: 0px">
	<li style="text-align: center; padding-bottom: 0.75em;"><a href="http://www.bawbaw.co/hosting/v360lab/album.php?user_name=<?php echo htmlspecialchars($user_name);?>" style="color: white;">My Album</a></li>
	<li style="text-align: center; padding-bottom: 0.75em;"><a href="#" style="color: white;">Pricing</a></li>
	<li style="text-align: center; padding-bottom: 0.75em;"><a href="#" style="color: white;">FAQ's</a></li>
	<?php if(isset($_COOKIE['v360duser']))
		{
			$value = $_COOKIE['v360duser'];
			if((verifyJWT('sha256', $value))==true)
			{
				echo "<li style='text-align: center;'><a href='http://www.bawbaw.co/hosting/v360lab/inc/signout.php' style='color: white;'>Sign Out</a></li>";
			}
			else {
				echo '<li style="text-align: center;"><a href="http://www.bawbaw.co/hosting/v360lab/login.php" style="color: white;">Log in</a></li>';
			}
		}
		else {
			echo '<li style="text-align: center;"><a href="http://www.bawbaw.co/hosting/v360lab/login.php" style="color: white;">Log in</a></li>';
		}?>
   </ul>
   </div>
	</header>
	<div class ="container">
	<h4 class = "heading"><?php echo htmlspecialchars($product_name);?></h4>
	<div id="main-content">
		<div id="rotator">
	<div id="image-container">
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
<p>By <?php echo htmlspecialchars($company_name);?></p>
</div>
<div class="description">
<h5>DESCRIPTION</h5>
<p style="text-align: justify"><?php echo htmlspecialchars($product_description);?></p>
<h5 style="padding-bottom: 0.5em">SHARE</h5>
<span>
<a href="https://www.facebook.com/sharer/sharer.php?u=#url" target="_blank"><img src="img/res/icons8-facebook-24.png" class="social-media"></a>
<a href = "https://twitter.com/intent/tweet?url=<?=urlencode($url)?>" target="_blank"><img src="img/res/icons8-twitter-24.png" class="social-media"></a>
<a href="http://pinterest.com/pin/create/bookmarklet/?url=<?php echo $url;?>"><img src="img/res/icons8-pinterest-26.png" class="social-media"></a>
<a href = "https://www.linkedin.com/shareArticle?mini=true&url=<?php echo $url;?>&title=360%20Image&source=LinkedIn"><img src="img/res/icons8-linkedin-24.png" class="social-media"></a></span>
<h5 style="padding-bottom: 0.5em">EMBED IN YOUR WEBSITE!</h5>
<p id ="url" style="position: relative; word-wrap: break-word;">&lt;iframe
  width="<?php echo $iwidth;?>"
  height="<?php echo $iheight;?>"
   style="border:0"
  src="http://www.bawbaw.co/hosting/v360lab/iframeview.php?user_name=<?php echo $user_name;?>&product_name=<?php echo $product_name;?>" allowfullscreen&gt;
&lt;/iframe&gt;<img src = "img/res/baseline-file_copy-24px.svg" style="position: absolute; top: 0px; right: 0px; cursor: pointer" id = 'copy' title="Copy to Clipboard"></p>
</div>
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
<div class="footer">
	<ul class="footer-nav">
		<li style="padding-right:1em; border-right:1px solid black"><a href="#">About Us</a></li>
		<li style="padding-left: 1em; padding-right: 1em; border-right: 1px solid black"><a href="#">Enquire</a></li>
		<li style="padding-left: 1em"><a href="#">Contact Us</a></li>
		<li class="address"><a href="index.html">www.V360Lab.com</a></li>
	</ul>
</div>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script type="text/javascript" src="app.js"></script>
		<script type="text/javascript" src="js/nav.js"></script>
		<script type="text/javascript">
		$('#copy').on('click', ()=>{
			var cc = $('#url').text();
			var dummy = document.createElement('input');
			document.body.appendChild(dummy);
			dummy.value = cc;
			dummy.select();
			document.execCommand('copy');
			dummy.remove();
			alert('Code copied to clipboard');
		});
		</script>
</body>
</html>
