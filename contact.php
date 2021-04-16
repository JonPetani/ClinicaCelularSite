<!--
Developer: Jonathan Petani
Date: April 2020 - April 2021
Purpose: Contains Contact and Location Information.
-->
<html>
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
<link href="CSS/main.css" rel="stylesheet"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
<script src="JS/formsetup.js"></script>
<title>Contact Us : Clínica Celular</title>
<link href="Images/TabImg.png" rel="icon"/>
</head>
<body>
<?php
require "PHPAssets/connect.php";
require "PHPAssets/pagetools.php";
?>
<div class="container" style='background-color:CornFlowerBlue;'>
<div class="container" style='background-color:DarkSlateBlue;'>
<?php
setAccountTabs($con);
?>
</div>
<div class='container bg-primary text-white'>
<br>
<h1>Contact Us</h1>
<p>Our company strives to provide you quality electronic products and services for your electronics at a good price. If you have any questions, comments, or suggestions for us, we would love to hear them.</p>
<div class='row'>
<div class='col-sm-7'>
<h2>Our Location</h2>
<p>We operate out of Mexico City.</p>
<h3>Address</h3>
<address>Fan Center Eje Central Lázaro Cárdenas 11, Colonia Centro, Centro, Cuauhtémoc, 06000 Ciudad de México, CDMX 55 5521 0702</address>
<!-- Business Location-->
<div class="mapouter"><div class="gmap_canvas"><iframe width="600" height="625" id="gmap_canvas" src="https://maps.google.com/maps?q=Fan%20Center%20Eje%20Central%20L%C3%A1zaro%20C%C3%A1rdenas%2011,%20Colonia%20Centro,%20Centro,%20Cuauht%C3%A9moc,%2006000%20Ciudad%20de%20M%C3%A9xico,%20CDMX%2055%205521%200702&t=&z=15&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe><a href="https://123movies-to.org">123movies</a><br><style>.mapouter{position:relative;text-align:right;height:625px;width:600px;}</style><a href="https://www.embedgooglemap.net"></a><style>.gmap_canvas {overflow:hidden;background:none!important;height:625px;width:600px;}</style></div></div></div>
<div class='col-sm-4' style='background-color:SteelBlue;'>
<h2>Message Us Directly</h2>
<form>
<?php
//determines which contact form should be visible whether viewer is customer logged in or new visitor
if(isset($_SESSION['type'])) {
	if(strcmp($_SESSION['type'], 'customer') != 0) {
		echo "<div class='row'>";
		echo "<input name='Name' type='text' autocomplete='false' placeholder='Your Name' required/>";
		echo "</div>";
		echo "<br>";
		echo "<div class='row'>";
		echo "<input name='Phone' type='text' autocomplete='false' placeholder='A Phone Number To Reach You' required/>";
		echo "</div>";
		echo "<br>";
		echo "<div class='row'>";
		echo "<input name='Email' type='text' autocomplete='false' placeholder='A Email Address To Reach You' required/>";
		echo "</div>";
		echo "<br>";
	}
	else {
		echo "<div class='row'>";
		echo "<p>Your Logged In Already, So We Got Your Contact Info Already. Just Tell What You Need Help With And How You Would Like To Be Reached.</p>";
		echo "</div>";
		echo "<br>";
		echo "<div class='row'>";
		echo "<div class='col'>";
		echo "<label for='Call'>Call Me</label>";
		echo "<input type='radio' id='Call' name='Reach' value='Call' autocomplete='false' required/>";
		echo "</div>";
		echo "<div class='col'>";
		echo "<label for='Text'>Text Me</label>";
		echo "<input type='radio' id='Text' name='Reach' value='Text' autocomplete='false' required/>";
		echo "</div>";
		echo "<div class='col'>";
		echo "<label for='Email'>Email</label>";
		echo "<input type='radio' id='Email' name='Reach' value='Emal' autocomplete='false' required/>";
		echo "</div>";
		echo "</div>";
		echo "<br>";
	}
}
else {
	echo "<div class='row'>";
	echo "<input name='Name' type='text' autocomplete='false' placeholder='Your Name' required/>";
	echo "</div>";
	echo "<br>";
	echo "<div class='row'>";
	echo "<input name='Phone' type='text' autocomplete='false' placeholder='A Phone Number To Reach You' required/>";
	echo "</div>";
	echo "<br>";
	echo "<div class='row'>";
	echo "<input name='Email' type='text' autocomplete='false' placeholder='A Email Address To Reach You' required/>";
	echo "</div>";
	echo "<br>";
}
?>
<div class="row">
<input type='text' name="Topic" placeholder="Topic of Issue(Makes Easier To Find)" required autocomplete="false"/>
</div>
<br>
<div class="row">
<textarea name="Desc" placeholder="Tell Us What Your Problem is in Detail so we can Help you." required autocomplete="false"></textarea>
</div>
<br>
<div class="row">
<input type='submit' name='Send'/>
</div>
</form>
<h2>Contacts</h2>
<h3>Email</h3>
<address>clinicacelularcdmc@gmail.com</address>
<h3>Phone</h3>
<address>000-000-0000</address>
<h2>Connect with us on Social Media</h2>
<div class='row'>
<div class='col-sm-4'><a href='https://www.facebook.com/clinicadelcelularmexico'><img src='Images/facebook.png' style='width:75%;height:85%;' title='Facebook' alt='Facebook'></a></div>
<div class='col-sm-4'><a href='https://www.instagram.com/clinicacelularmx/'><img src='Images/instagram.png' style='width:75%;height:85%;' title='Instagram' alt='Instagram'></a></div>
<div class='col-sm-4'><a href='https://api.whatsapp.com/send?phone=525510634948&fbclid=IwAR1f-PwOaB2ra3UY4LwG3s556mVBXYaz2FVhEnxWWd49aAiyl_AqP2GI_nQ'><img src='Images/whatsapp.png' style='width:75%;height:85%;' title='WhatsApp' alt='WhatsApp'></a></div>
</div>
</div>
</div>
<br>
</div>
<script>
smallFormSetup();
</script>
<script src="https://code.jquery.com/jquery-3.5.0.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
</div>
<div class="container" style='background-color:DarkSlateBlue;'>
<ul class="nav justify-content-center">
<li class='nav-item dropdown'>
<a class='nav-link dropdown-toggle' data-toggle='dropdown' href=''>Our Services</a>
<div class='dropdown-menu' style="overflow-y:auto;">
<a class='dropdown-item' href='store.php'>Online Store</a>
<a class='dropdown-item' href='repairshop.php'>Repair Services</a>
<a class='dropdown-item' href=''>Security System Installation</a>
</div>
</li>
<li class='nav-item dropdown'>
<a class='nav-link dropdown-toggle' data-toggle='dropdown' href=''>Social Media</a>
<div class='dropdown-menu' style="overflow-y:auto;">
<a class='dropdown-item fa fa-facebook' href='https://www.facebook.com/clinicadelcelularmexico'></a>
<a class='dropdown-item fa fa-instagram' href='https://www.instagram.com/clinicacelularmx/'></a>
<a class='dropdown-item' href='https://api.whatsapp.com/send?phone=525510634948&fbclid=IwAR1f-PwOaB2ra3UY4LwG3s556mVBXYaz2FVhEnxWWd49aAiyl_AqP2GI_nQ'>WhatsApp</a>
</div>
</li>
<li class='nav-item'>
<a class='nav-link' href='reviews.php'>Reviews</a>
</li>
<li class='nav-item'>
<a class='nav-link' href='careers.php'>Careers</a>
</li>
</ul>
<br>
<div align=center>Icons made by <a href="https://www.freepik.com" title="Freepik">Freepik</a> from <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a></div>
<br>
<div class='row'>
<div class="col-sm-4"><a href="Home.php"><img src="Images/ClinicaIcon.png" class='colordiff'  style='width:75%;height:80%;background-color:MediumPurple;' title="Clinica Celular" alt="Clinica Celular"/></a></div>
<div class="col-sm-4">
<ul class="nav justify-content-center">
<li class='nav-item'>
<a class='nav-link' style='font-size:75%;' href='sitemap.php'>Sitemap</a>
</li>
<li class='nav-item'>
<a class='nav-link' style='font-size:75%;' href='recalls.php'>Recalls</a>
</li>
<li class='nav-item'>
<a class='nav-link' style='font-size:75%;' href='terms.php'>Terms</a>
</li>
<li class='nav-item'>
<a class='nav-link' style='font-size:75%;' href='privacy.php'>Privacy + Security</a>
</li>
</ul>
</div>
</div>
</div>
</body>
</html>