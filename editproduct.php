<?php
require_once __DIR__ . '/inc/functions.php';
require_once __DIR__ . '/inc/connection.php';
$product_image = 'img/res/placeholder (1).png';
$photonumber = '72';
$imageaspectratio = '4:3';
$imagefiletype = 'jpg';
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
	$response = $db->query("SELECT company_name FROM user WHERE user_name = '$user_name'");
	$results = $response->fetch(PDO::FETCH_ASSOC);
	$company_name = $results['company_name'];
}
else{
	header('location: http://www.bawbaw.co/hosting/v360lab/login.php');
	exit;
}
if(isset($_GET['product_name']))
{
	$oldproduct_name = $_GET['product_name'];
	$response = $db->query("SELECT product_list FROM user_products WHERE user_name = '$user_name'");
	$results = $response->fetch(PDO::FETCH_ASSOC);
	$obj = json_decode($results['product_list']);
	foreach ($obj as $value) {
		if($value->product_name==$oldproduct_name)
		{
			$product_image = $value->product_image;
			$photonumber = $value->photonumber;
			$imageaspectratio = $value->imageaspectratio;
			$product_description = $value->product_description;
			break;
		}
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
  <link rel="stylesheet" href="css/accountcss.css">
	<link rel="stylesheet" href="css/edit.css">
  <link rel="stylesheet" href="css/albumedit.css">
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
        <li style="border-bottom:1px solid black" class = "passive"><a href="http://www.bawbaw.co/hosting/v360lab/account.php?user_name=<?php echo htmlspecialchars($user_name);?>"><strong>My Account</strong></a></li>
        <li style="background-color:#190729; position: relative" class ="active"><a href="http://www.bawbaw.co/hosting/v360lab/album.php?user_name=<?php echo htmlspecialchars($user_name);?>" style="color: white;"><strong>Album</strong></a><i class="material-icons" id = "sub_dropdown">keyboard_arrow_down</i><i class="material-icons" id = "sub_dropup">keyboard_arrow_up</i></li>
        <li style="border-bottom:1px solid black" class = "passive"><a href=""><strong>Billing History</strong></a></li>
        <li style="border-bottom:1px solid black" class = "passive"><a href=""><strong>Extra Column</strong></a></li>
      </ul>
    </div>
    <div id = "details">
      <h2>Add / Edit Product</h2>
      <form action="http://www.bawbaw.co/hosting/v360lab/inc/addproduct.php?user_name=<?php echo htmlspecialchars($user_name);?>&oldproduct_name=<?php echo $oldproduct_name;?>" method="post" enctype="multipart/form-data" onsubmit="return validateProductName()">
				<span class="tips">Valid Product name cannot contain these characters [\, /, :, <, >, ?, ", |]</span>
				<div class="edittab">
        <label for = "productname"><strong>Product Name</strong></label>
        <input type="text" id ="productname" name="product_name" required value="<?php echo htmlspecialchars($oldproduct_name);?>"/>
			</div>
      <div class="edittab">
        <label for = "productimage"><strong>Add Images</strong></label>
				<div class="productimagecontainer">
				<img src="<?php echo $product_image;?>" id ="productimage">
				<div class="progress">
					<div class="bar"></div>
					<div class="percent">0%</div>
				</div>
        <label class="custom-file-upload" id ="cover"><input type="file" id ="productimage" name="product_image[]" accept="image/*" multiple>Select Images for Upload</label>
			</div>
    </div>
			<div class="edittab">
        <label for="photonumber"><strong>No. of Images</strong></label>
        <select id ="photonumber" name="photonumber" required>
					<?php echo "<option value='$photonumber' selected>$photonumber</option>"?>
        </select>
			</div>
      <div class="edittab">
        <label for="imageaspectratio"><strong>Image Aspect Ratio</strong></label>
        <select id ="imageaspectratio" name="imageaspectratio" required>
					<?php echo "<option value='$imageaspectratio' selected>$imageaspectratio</option>"?>
        </select>
			</div>
			<div class="edittab">
				<label for="imagefiletype"><strong>Image File Type</strong></label>
				<select id ="imagefiletype" name="imagefiletype" required>
					<?php echo "<option value='$imagefiletype' selected>$imagefiletype</option>"?>
				</select>
			</div>
      <div class="edittab">
        <label for = "productdescription"><strong>Product Description</strong></label>
      <textarea name="product_description" id ="productdescription" required><?php echo $product_description;?></textarea>
    </div>
      <div class="edittab">
        <label><strong>Company Name</strong></label>
        <span id ="compname"><?php echo $company_name;?></span>
			</div>
			<div class="buttons">
				<button type="submit" id ='submit_btn'>Save</button>
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
	<script src="http://malsup.github.com/jquery.form.js"></script>
    <script type="text/javascript" src="js/acc.js"></script>
		<script type="text/javascript" src="js/nav.js"></script>
		<script type="text/javascript">
		let flag1 = false;
    function validateProductName()
		{
			let product_name = $('#productname').val();
			if(product_name.includes('/') || product_name.includes('\\') || product_name.includes(':') || product_name.includes('*') || product_name.includes('?') || product_name.includes('\"') || product_name.includes('<') || product_name.includes('>') || product_name.includes('|'))
			{
				flag1 = true;
		    $("#productname").addClass("redborder");
		    $(".tips").css("display", "block");
		    return false;
			}
			else {
				return true;
			}
		}
		$("#productname").on("focus", ()=>{
 	   if(flag1==true)
 	   {
 	     $("#productname").removeClass("redborder");
 	     $(".tips").hide();
 	     flag1 = false;
 	   }
 	 });
		</script>
		<script>
(function() {

var bar = $('.bar');
var percent = $('.percent');
var status = $('#status');

$('form').ajaxForm({
    beforeSend: function() {
        var percentVal = '0%';
        bar.width(percentVal)
        percent.html(percentVal);
    },
    uploadProgress: function(event, position, total, percentComplete) {
        var percentVal = percentComplete + '%';
        bar.width(percentVal)
        percent.html(percentVal);
		//console.log(percentVal, position, total);
    },
    success: function() {
        var percentVal = '100%';
        bar.width(percentVal)
        percent.html(percentVal);
				location.href = "http://www.bawbaw.co/hosting/v360lab/album.php?user_name=<?php echo htmlspecialchars($user_name);?>";
    }
});

})();
</script>
<script type="text/javascript">
let aspectarray = ['4:3', "3:2", "1:1", "16:9"];
let imgtypearray = ['jpg', 'png'];
let photonoarray = ['72', '90', '54', '36'];
for(let i=0;i<aspectarray.length;i++)
{
	if(aspectarray[i]!=$('#imageaspectratio').val())
	{
		let opt = "<option value='" + aspectarray[i] + "'>" + aspectarray[i] + "</option>";
		$('#imageaspectratio').append(opt);
	}
}
for(let i=0;i<imgtypearray.length;i++)
{
	if(imgtypearray[i]!=$('#imagefiletype').val())
	{
		let opt = "<option value='" + imgtypearray[i] + "'>" + imgtypearray[i] + "</option>";
		$('#imagefiletype').append(opt);
	}
}
for(let i=0;i<photonoarray.length;i++)
{
	if(photonoarray[i]!=$('#photonumber').val())
	{
		let opt = "<option value='" + photonoarray[i] + "'>" + photonoarray[i] + "</option>";
		$('#photonumber').append(opt);
	}
}
</script>
</body>
</html>
