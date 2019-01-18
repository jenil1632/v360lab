<?php
require_once __DIR__ . '/inc/functions.php';
require_once __DIR__ . '/inc/connection.php';
if(isset($_GET['user_name']))
{
	$user_name = $_GET['user_name'];
	if(isset($_COOKIE['v360duser']))
	{
		$value = $_COOKIE['v360duser'];
		if((verifyJWT('sha256', $value))==false || returnusername($value)!==$user_name)
		{
			header('location: http://www.bawbaw.co/hosting/v360lab/login.php');
			exit;
		}
	}
	else{
		header('location: http://www.bawbaw.co/hosting/v360lab/login.php');
		exit;
	}
	$response = $db->query("SELECT all_filled FROM user_info WHERE user_name = '$user_name'");
	$results = $response->fetch(PDO::FETCH_ASSOC);
	if($results['all_filled']==false)
	{
	  header("location: http://www.bawbaw.co/hosting/v360lab/edit.php?user_name=$user_name");
	}
	$response = $db->query("SELECT product_list FROM user_products WHERE user_name = '$user_name'");
	$results = $response->fetch(PDO::FETCH_ASSOC);
	$obj = json_decode($results['product_list']);
}
else{
	header('location: http://www.bawbaw.co/hosting/v360lab/login.php');
	exit;
}
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
  <link rel="stylesheet" href="css/accountcss.css">
	<link rel="stylesheet" href="css/edit.css">
  <link rel="stylesheet" href="css/album.css">
</head>
<body>
	<header class="main-header">
		<div class="top-bar">
		<h5 class="name"><a href="index.html">V360&deg; LAB</a></h5>
		<ul class="nav">
			<li><a href="http://www.bawbaw.co/hosting/v360lab/album.php?user_name=<?php echo htmlspecialchars($user_name);?>">My Album</a></li>
			<li><a href="#">Pricing</a></li>
			<li><a href="#">FAQ's</a></li>
			<li><a href="http://www.bawbaw.co/hosting/v360lab/inc/signout.php">Sign Out</a></li>
		</ul>
		<h5 class="dropdown-menu">MENU</h5>
		<i class="material-icons" id = "dropdown-arrow">keyboard_arrow_down</i>
	</div>
	<div id = "mobile-nav">
	<ul style="padding-left: 0px">
	<li style="text-align: center; padding-bottom: 0.75em;"><a href="http://www.bawbaw.co/hosting/v360lab/album.php?user_name=<?php echo htmlspecialchars($user_name);?>" style="color: white;">My Album</a></li>
	<li style="text-align: center; padding-bottom: 0.75em;"><a href="#" style="color: white;">Pricing</a></li>
	<li style="text-align: center; padding-bottom: 0.75em;"><a href="#" style="color: white;">FAQ's</a></li>
	<li style='text-align: center;'><a href='http://www.bawbaw.co/hosting/v360lab/inc/signout.php' style='color: white;'>Sign Out</a></li>
	 </ul>
	 </div>
	</header>
  <div class ="container">
    <div id = "side_nav">
      <ul>
        <li style="border-bottom:1px solid black" class = "passive"><a href="http://www.bawbaw.co/hosting/v360lab/account.php?user_name=<?php echo $user_name;?>"><strong>My Account</strong></a></li>
        <li style="background-color:#190729; color: white; position: relative" class ="active"><strong>Album</strong><i class="material-icons" id = "sub_dropdown">keyboard_arrow_down</i><i class="material-icons" id = "sub_dropup">keyboard_arrow_up</i></li>
        <li style="border-bottom:1px solid black" class = "passive"><a href=""><strong>Billing History</strong></a></li>
        <li style="border-bottom:1px solid black" class = "passive"><a href=""><strong>Extra Column</strong></a></li>
      </ul>
    </div>
    <div id = "details">
			<div id = "detail-header">
      <h2>Products</h2>
			<div class = "toolbuttons">
			<img src = "img/res/add.svg" class = "toolbutton" style="margin-left: auto" id = 'add'>
			<img src = "img/res/delete.svg" class = "toolbutton" id = "delete">
		</div>
		</div>
      <div id = "products">
				<?php
				if(count($obj)>0)
				{
					foreach ($obj as $value) {
						echo "<div class='productwrapper'>";
							echo "<img src ='$value->product_image' class = 'productimage'>";
							echo "<h4 class ='productname'>$value->product_name</h4>";
							echo "<hr></hr>";
							echo "<table>";
								echo "<tr>";
									echo "<td>Updated On</td>";
									echo "<td><strong>$value->startDate</strong></td>";
									echo "</tr>";
									echo "<tr>";
										echo "<td>Valid upto</td>";
										echo "<td><strong>$value->endDate</strong></td>";
									echo "</tr>";
									echo "<tr>";
										echo "<td><a id = 'cclink' href='http://www.bawbaw.co/hosting/v360lab/productview.php?user_name=$user_name&product_name=$value->product_name'><button><strong>View</strong></button></a></td>";
										echo "<td><a href='http://www.bawbaw.co/hosting/v360lab/editproduct.php?user_name=$user_name&product_name=$value->product_name'><button><strong>Edit</strong></button></a></td>";
									echo "</tr>";
							echo "</table>";
							echo "<button class='link'><strong>Copy Link</strong></button>";
						echo "</div>";
					}
				}
				else {
					echo '<h2>No albums to show</h2>';
				}
				?>
    </div>
    </div>
  </div>
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
    <script type="text/javascript" src="js/acc.js"></script>
		<script type="text/javascript" src="js/add_delete.js"></script>
		<script type="text/javascript" src="js/nav.js"></script>
		<?php if($_GET['product']=='exists')
		{echo '<script type="text/javascript">alert("This product name already exists, try a different product name or delete prexisting file.");</script>';
		}?>
		<?php if($_GET['page']=='error')
		{echo '<script type="text/javascript">alert("Invalid Product Name or Product Description.");</script>';
		}?>
</body>
</html>
