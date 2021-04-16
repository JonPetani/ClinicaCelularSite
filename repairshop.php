<!--
Developer: Jonathan Petani
Date: April 2020 - April 2021
Purpose: Main Page for Repair Services. Goes Over Store Repair Services Acting As A Nav To Repair Services
-->
<html>
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
<link href="CSS/main.css" rel="stylesheet"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
<script src="JS/formsetup.js"></script>
<script src="JS/pagesetup.js"></script>
<title>Electronic Services : Clínica Celular</title>
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
<h1>Our Repair Services</h1>
<p>Whether you have problems with your hardware, broke your phone, or need to remove viruses, our tech services will have your devices working good as new.</p>
<div id='repair' class='carousel slide' data-ride='carousel'>
<ul class='carousel-indicators'>
<li data-target='#repair' data-slide-to='0' class='active'></li>
<li data-target='#repair' data-slide-to='1'></li>
<li data-target='#repair' data-slide-to='2'></li>
<li data-target='#repair' data-slide-to='3'></li>
<li data-target='#repair' data-slide-to='4'></li>
<li data-target='#repair' data-slide-to='5'></li>
<li data-target='#repair' data-slide-to='6'></li>
<li data-target='#repair' data-slide-to='7'></li>
</ul>
<!-- repair service slideshow -->
<div class='carousel-inner'>
<div class='carousel-item active'><img src='Images/Prototypes/3ABRIL2020.jpg' style='width:100%;height:70%;' title='Service Image' alt='Repair Service Image 1'/></div>
<div class='carousel-item'><img src='Images/Prototypes/5ABRIL2020.jpg' style='width:100%;height:70%;' title='Service Image' alt='Repair Service Image 2'/></div>
<div class='carousel-item'><img src='Images/Prototypes/10ABRIL2020.jpg' style='width:100%;height:70%;' title='Service Image' alt='Repair Service Image 3'/></div>
<div class='carousel-item'><img src='Images/Prototypes/18ABRIL2020.jpg' style='width:100%;height:70%;' title='Service Image' alt='Repair Service Image 4'/></div>
<div class='carousel-item'><img src='Images/Prototypes/24ABRIL2020.jpg' style='width:100%;height:70%;' title='Service Image' alt='Repair Service Image 5'/></div>
<div class='carousel-item'><img src='Images/Prototypes/31ABRIL2020.jpg' style='width:100%;height:70%;' title='Service Image' alt='Repair Service Image 6'/></div>
<div class='carousel-item'><img src='Images/Prototypes/39ABRIL2020.jpg' style='width:100%;height:70%;' title='Service Image' alt='Repair Service Image 7'/></div>
<div class='carousel-item'><img src='Images/Prototypes/52ABRIL2020.jpg' style='width:100%;height:70%;' title='Service Image' alt='Repair Service Image 8'/></div>
</div>
<a class="carousel-control-prev" href="#repair" data-slide="prev">
<span class="carousel-control-prev-icon"></span>
</a>
<a class="carousel-control-next" href="#repair" data-slide="next">
<span class="carousel-control-next-icon"></span>
</a>
</div>
<br>
<h2>Find Repair Services By Device</h2>
<!--repair services nav-->
<div class='row' style='background-color: #007bff'>
<div class='col-sm-3'><a href='services.php?device=android' onmouseover='collapseImageText(this)' onmouseout='unCollapseImageText(this)'><img src='Images/templates/android_firmware.png' style='width:75%;height:75%;padding-left:75px;' title='Android' alt='Android'><div class='collapse'><h3>Androids</h3></div></a></div>
<div class='col-sm-3'><a href='services.php?device=iphone' onmouseover='collapseImageText(this)' onmouseout='unCollapseImageText(this)'><img src='Images/Cambiodsiplay.jpg' style='width:75%;height:75%;padding-left:75px;' title='IPhone' alt='IPhone'><div class='collapse'><h3>Iphones</h3></div></a></div>
<div class='col-sm-3'><a href='services.php?device=ipad' onmouseover='collapseImageText(this)' onmouseout='unCollapseImageText(this)'><img src='Images/Prototypes/42ABRIL2020.jpg' style='width:75%;height:75%;padding-left:75px;' title='IPad' alt='IPad'><div class='collapse'><h3>Ipads</h3></div></a></div>
<div class='col-sm-3'><a href='services.php?device=applewatch' onmouseover='collapseImageText(this)' onmouseout='unCollapseImageText(this)'><img src='Images/Prototypes/50ABRIL2020.jpg' style='width:75%;height:75%;padding-left:75px;' title='Apple Watch' alt='Apple Watch'><div class='collapse'><h3>Apple Watches</h3><br></div></a></div>
</div>
<br>
</div>
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
</div>=
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
<div class='row'>
<div class="col-sm-4"><a href="Home.php"><img src="Images/ClinicaIcon.png" class='colordiff' style='width:75%;height:80%;background-color:MediumPurple;' title="Clinica Celular" alt="Clinica Celular"/></a></div>
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