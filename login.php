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
			<li><a href="#">Log in</a></li>
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
    <form action = "http://www.bawbaw.co/hosting/v360lab/inc/loginverify.php" method = "post">
      <h4 id = "heading">Log in to your Account</h4>
			<div id = "error">Incorrect Login Id or Password!</div>
      <input type = "text" id = "name" name = "user_name" placeholder="Username" class ="inputField" required>
      <input type = "password" id = "password" name = "user_password" placeholder="Password" class ="inputField" required>
      <p id = "terms">By continuing with any of the options below, you agree to our <strong>Terms of Service</strong></p>
      <button type="submit" id ="login"><strong>Log in</strong></button>
      <h6 id = "line">OR</h6>
      <button type="button" id ="glogin"><img src="img/res/icons8-google-24.png" id ="google"> <strong>Continue with google</strong></button>
      <p class ="dlg"><a href="http://www.bawbaw.co/hosting/v360lab/forgotpassword.php">Forgot your password ?</a></p>
      <p class ="dlg"><a href="http://www.bawbaw.co/hosting/v360lab/signup.php">Sign up</a></p>
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
	<script type="text/javascript" src = "js/formerror.js"></script>
	<script type="text/javascript" src="js/nav.js"></script>
</body>
</html>
