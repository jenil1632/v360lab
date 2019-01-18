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
	$response = $db->query("SELECT * FROM user_info WHERE user_name ='$user_name'");
	$results = $response->fetch(PDO::FETCH_ASSOC);
	$logo_image = 'img/res/placeholder.png';
	if($results['all_filled']==true)
	{
		$full_name = $results['full_name'];
		$email_id = $results['email_id'];
		$address_line1 = $results['address_line1'];
		$address_line2 = $results['address_line2'];
		$state = $results['state'];
		$city = $results['city'];
		$pincode = $results['pincode'];
		$logo_image = $results["logo_image"];
		$logo_image = strstr($logo_image, 'uploads');
	}
	if($logo_image==Null)
	{
		 $logo_image = 'img/res/placeholder.png';
	}
	$q = $db->query("SELECT mobile_number, company_name FROM user WHERE user_name = '$user_name'");
	$val = $q->fetch(PDO::FETCH_ASSOC);
	$mobile_number = $val['mobile_number'];
	$company_name = $val['company_name'];
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
        <li style="background-color:#190729; position: relative" class ="active"><a href="http://www.bawbaw.co/hosting/v360lab/account.php?user_name=<?php echo htmlspecialchars($user_name);?>" style="color: white;"><strong>My Account</strong></a><i class="material-icons" id = "sub_dropdown" style="color: white">keyboard_arrow_down</i><i class="material-icons" id = "sub_dropup" style="color: white">keyboard_arrow_up</i></li>
        <li style="border-bottom:1px solid black" class = "passive"><a href="http://www.bawbaw.co/hosting/v360lab/album.php?user_name=<?php echo htmlspecialchars($user_name);?>"><strong>Album</strong></a></li>
        <li style="border-bottom:1px solid black" class = "passive"><a href=""><strong>Billing History</strong></a></li>
        <li style="border-bottom:1px solid black" class = "passive"><a href=""><strong>Extra Column</strong></a></li>
      </ul>
    </div>
    <div id = "details">
      <h2><?php echo htmlspecialchars($user_name); ?></h2>
      <form action="http://www.bawbaw.co/hosting/v360lab/inc/userinfo.php?user_name=<?php echo htmlspecialchars($user_name);?>" method="post" enctype="multipart/form-data" onsubmit="return validateform()">
				<div class="edittab">
        <label for = "name"><strong>Full Name</strong></label>
        <input type="text" id ="name" name="full_name" required value="<?php echo htmlspecialchars($full_name);?>"/>
			</div>
			<div class="edittab">
        <label for = "emailid"><strong>Email Id</strong></label>
        <input type="email" id ="emailid" name="email_id" required value="<?php echo htmlspecialchars($email_id);?>"/>
			</div>
			<div class="edittab">
        <label for = "mobileno"><strong>Mobile Number</strong></label>
        <input type="tel" id ="mobileno" name="mobile_number" required value="<?php echo htmlspecialchars($mobile_number);?>"/>
			</div>
			<div class="edittab">
        <label for = "password"><strong>Password</strong></label>
        <input type="password" id ="password" name="user_password" required value = "##########"/>
			</div>
			<span class="tips" id = 'pass'>Password should be 7 characters or longer</span>
			<div class="edittab">
        <label for = "confirmpassword"><strong>Confirm Password</strong></label>
        <input type="password" id ="confirmpassword" name="confirm_password" required value = "##########"/>
			</div>
			<span class="tips" id = 'confpass'>Passwords do not Match</span>
			<div class="edittab">
        <label for = "company"><strong>Company /Brand</strong></label>
        <input type="text" id ="company" name="company_name" required value="<?php echo htmlspecialchars($company_name);?>"/>
			</div>
			<div class="edittab">
        <label for = "logo"><strong>Brand Logo</strong></label>
				<div class="edittablogo">
				<img src="<?php echo $logo_image;?>" height="100px" width="100px" id ="logo">
        <label class="custom-file-upload" id ="cover"><input type="file" id ="logo" name="logo_image" accept="image/*"/>Add / Change</label>
			</div>
			</div>
			<div class="edittab">
        <label for = "address1"><strong>Address Line 1</strong></label>
        <input type="text" id ="address1" name="address_line1" required value="<?php echo htmlspecialchars($address_line1);?>"/>
			</div>
			<div class="edittab">
        <label for = "address2"><strong>Address Line 2</strong></label>
        <input type="text" id ="address2" name="address_line2" required value="<?php echo htmlspecialchars($address_line2);?>"/>
			</div>
			<div class="edittab">
        <label for="state"><strong>State</strong></label>
        <select id ="state" name="state" required>
					<?php echo "<option value='$state' selected>$state</option>";?>
          </select>
			</div>
			<div class="edittab">
        <label for="city"><strong>City / District</strong></label>
				<select id ="city" name ="city" required>
					<?php echo "<option value='$city' selected>$city</option>"?>
				</select>
			</div>
			<div class="edittab">
				<label for="pincode"><strong>Pincode</strong></label>
				<input type="number" id ="pincode" name="pincode" required value="<?php echo htmlspecialchars($pincode);?>"></input>
			</div>
			<div class="buttons">
				<button type="submit">Save</button>
				<button type="reset" onclick="clearCity()">Clear</button>
			</div>
      </form>
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
		<script type="text/javascript" src="js/edit.js"></script>
		<script type="text/javascript" src="js/nav.js"></script>
		<?php if($results['all_filled']==true)
		{
			?><script type="text/javascript">$('button[type="reset"]').hide();</script>
		<?php }  ?>
</body>
</html>
