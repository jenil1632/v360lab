<?php
require_once __DIR__ . '/inc/functions.php';
require_once __DIR__ . '/inc/connection.php';
if(isset($_GET['user_name']))
{
$user_name = $_GET['user_name'];
}
else {
  header('location: http://www.bawbaw.co/hosting/v360lab/login.php');
}
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
$response = $db->query("SELECT * FROM user_info WHERE user_name = '$user_name'");
$results = $response->fetch(PDO::FETCH_ASSOC);
if($results['all_filled']==false)
{
  header("location: http://www.bawbaw.co/hosting/v360lab/edit.php?user_name=$user_name");
}
$full_name = $results["full_name"];
$email_id = $results["email_id"];
$address_line1 = $results["address_line1"];
$address_line2 = $results["address_line2"];
$city = $results["city"];
$state = $results["state"];
$pincode = $results["pincode"];
$logo_image = $results["logo_image"];
$response = $db->query("SELECT mobile_number, company_name FROM user WHERE user_name = '$user_name'");
$results = $response->fetch(PDO::FETCH_ASSOC);
$mobile_number = $results["mobile_number"];
$company_name = $results["company_name"];
$logo_image = strstr($logo_image, 'uploads');
if($logo_image==Null)
{
   $logo_image = 'img/res/placeholder.png';
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
        <li style="background-color:#190729; color: white; position: relative" class ="active"><strong>My Account</strong><i class="material-icons" id = "sub_dropdown">keyboard_arrow_down</i><i class="material-icons" id = "sub_dropup">keyboard_arrow_up</i></li>
        <li style="border-bottom:1px solid black" class = "passive"><a href="http://www.bawbaw.co/hosting/v360lab/album.php?user_name=<?php echo htmlspecialchars($user_name);?>"><strong>Album</strong></a></li>
        <li style="border-bottom:1px solid black" class = "passive"><a href=""><strong>Billing History</strong></a></li>
        <li style="border-bottom:1px solid black" class = "passive"><a href=""><strong>Extra Column</strong></a></li>
      </ul>
    </div>
    <div id = "details">
      <h2><?php echo htmlspecialchars($user_name); ?></h2>
			<span id ="mob_edit"><a href="http://www.bawbaw.co/hosting/v360lab/edit.php?user_name=<?php echo htmlspecialchars($user_name);?>">Edit</a></span>
      <table>
				<col style="width:30%">
				<col style="width:70%">
        <tr>
          <td><strong>Full Name</strong></td>
          <td><?php echo htmlspecialchars($full_name);?></td>
        </tr>
        <tr>
          <td><strong>Email Id</strong></td>
          <td><?php echo htmlspecialchars($email_id);?></td>
        </tr>
        <tr>
          <td><strong>Mobile No.</strong></td>
          <td><?php echo htmlspecialchars($mobile_number);?></td>
        </tr>
        <tr>
          <td><strong>Password</strong></td>
          <td>***********</td>
        </tr>
        <tr>
          <td><strong>Company /Brand</strong></td>
          <td><?php echo htmlspecialchars($company_name);?></td>
        </tr>
        <tr>
          <td><strong>Brand Logo</strong></td>
          <td><img src="<?php echo $logo_image;?>" height="100px" width="100px"></td>
        </tr>
        <tr>
          <td><strong>Address</strong></td>
          <td><?php echo htmlspecialchars($address_line1);?></td>
        </tr>
				<tr>
					<td></td>
					<td style="padding-top: 0"><?php echo htmlspecialchars($address_line2);?></td></tr>
					<tr>
						<td></td>
						<td style="padding-top: 0"><?php echo htmlspecialchars($city);?> <?php echo htmlspecialchars($state);?></td></tr>
        <tr>
          <td><strong>Pincode</strong></td>
          <td><?php echo htmlspecialchars($pincode);?></td>
        </tr>
      </table>
    </div>
    <div id = "edit">
      <h4><a href="http://www.bawbaw.co/hosting/v360lab/edit.php?user_name=<?php echo htmlspecialchars($user_name);?>">Edit</a></h4>
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
    <script type="text/javascript" src="js/nav.js"></script>
</body>
</html>
