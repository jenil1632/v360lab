<?php
require_once __DIR__ . '/inc/functions.php';
	if(isset($_COOKIE['v360duser']))
	{
		$value = $_COOKIE['v360duser'];
		if((verifyJWT('sha256', $value))==true)
		{
			$user_name = returnusername($value);
			header("location: http://www.bawbaw.co/hosting/v360lab/album.php?user_name=$user_name");
			exit;
		}
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
  <link rel="stylesheet" href="css/logincss.css">
</head>
<body>
	<header class="main-header">
		<div class="top-bar">
		<h5 class="name"><a href="index.html">V360&deg; LAB</a></h5>
		<ul class="nav">
			<li><a href="#">Benefits</a></li>
			<li><a href="#">Pricing</a></li>
			<li><a href="#">FAQ's</a></li>
			<li><a href="login.php">Log in</a></li>
		</ul>
		<h5 class="dropdown-menu">MENU</h5>
		<i class="material-icons" id = "dropdown-arrow">keyboard_arrow_down</i>
	</div>
	<div id = "mobile-nav">
	<ul style="padding-left: 0px">
	<li style="text-align: center; padding-bottom: 0.75em;"><a href="" style="color: white;">Benefits</a></li>
	<li style="text-align: center; padding-bottom: 0.75em;"><a href="#" style="color: white;">Pricing</a></li>
	<li style="text-align: center; padding-bottom: 0.75em;"><a href="#" style="color: white;">FAQ's</a></li>
	<li style="text-align: center;"><a href="login.php" style="color: white;">Log in</a></li>
	 </ul>
	 </div>
	</header>
  <div class ="container">
    <form action = "http://www.bawbaw.co/hosting/v360lab/inc/signupverify.php" method = "post" onsubmit ="return validateform()">
      <h4 id = "heading">Create Account</h4>
			<div id = "error">Please fill in valid entries in the required fields.</div>
      <input type = "text" id = "name" name = "user_name" placeholder="Username" class ="inputField" required>
			<span class="tips">Username already taken! Choose another Username</span>
      <span class="tips">Valid Username cannot contain whitespace and these characters [\, /, :, <, >, ?, ", |]</span>
      <input type = "password" id = "password" name = "user_password" placeholder="Password" class ="inputField" required>
			<span class="tips">Password should be 7 characters or longer</span>
      <input type = "password" id = "confirmpassword" name = "confirm_password" placeholder="Confirm Password" class ="inputField" required>
			<span class="tips">Passwords do not Match</span>
      <input type = "text" id = "companyname" name = "company_name" placeholder="Company /Brand Name" class ="inputField" required>
			<input type = "text" id = "honey" name = "honey" alt="Do not fill this field">
      <input type = "tel" id = "mobilenumber" name = "mobile_number" placeholder="Mobile Number" class ="inputField" required>
			<span class="tips">Mobile number is not valid</span>
      <p id = "terms">By continuing with any of the options below, you agree to our <strong><a href="">Terms of Service</a></strong> & <a href=""><strong>Privacy Policy</strong></a></p>
      <button type="submit" id ="login"><strong>Sign Up</strong></button>
      <p class ="dlg">Already have an account ?</p>
      <p class ="dlg"><a href="http://www.bawbaw.co/hosting/v360lab/login.php"><strong>Log in</strong></a></p>
    </form>
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
		<script type="text/javascript"src="js/uservalidate.js"></script>
		<script type="text/javascript" src="js/formerror.js"></script>
		<script type="text/javascript" src="js/nav.js"></script>
</body>
</html>
