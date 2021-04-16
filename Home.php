<!--
Developer: Jonathan Petani
Date: April 2020 - April 2021
Purpose: Main Page of Web App. Introduces To The Site.
-->
<html>
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
<link href="CSS/main.css" rel="stylesheet"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
<script src="JS/formsetup.js"></script>
<script src="JS/pagesetup.js"></script>
<title>Clínica Celular</title>
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
<h1>Welcome to Clinica Celular</h1>
<p>We are a Electronic Repair Shop that also sells Electronics related Products.</p>
<!-- Main Page Slideshow -->
<h2>No Matter What the Issue is, We have a Solution To The Problem</h2>
<div id='repair' class='carousel slide' data-ride='carousel'>
<ul class='carousel-indicators'>
<li data-target='#repair' data-slide-to='0' class='active'></li>
<li data-target='#repair' data-slide-to='1'></li>
<li data-target='#repair' data-slide-to='2'></li>
<li data-target='#repair' data-slide-to='3'></li>
<li data-target='#repair' data-slide-to='4'></li>
<li data-target='#repair' data-slide-to='5'></li>
<li data-target='#repair' data-slide-to='6'></li>
</ul>
<div class='carousel-inner'>
<div class='carousel-item active'><img src='Images/Servicio_a_domicilio.jpg' style='width:100%;height:75%;' title='Some of Our Services' alt='Image 1'/></div>
<div class='carousel-item'><img src='Images/ReparaciónSoftware.jpg' style='width:100%;height:75%;' title='Service Image' alt='Image 2'/></div>
<div class='carousel-item'><img src='Images/templates/slide_3.jpg' style='width:100%;height:75%;' title='Service Image' alt='Image 3'/></div>
<div class='carousel-item'><img src='Images/Equiposmojados.jpg' style='width:100%;height:75%;' title='Service Image' alt='Image 4'/></div>
<div class='carousel-item'><img src='Images/Samsungs10asistencia.jpg' style='width:100%;height:75%;' title='Service Image' alt='Image 5'/></div>
<div class='carousel-item'><img src='Images/Prototypes/22ABRIL2020.jpg' style='width:100%;height:75%;' title='Service Image' alt='Image 6'/></div>
<div class='carousel-item'><img src='Images/fixclinica.jpg' style='width:100%;height:75%;' title='Service Image' alt='Image 7'/></div>
</div>
<a class="carousel-control-prev" href="#repair" data-slide="prev">
<span class="carousel-control-prev-icon"></span>
</a>
<a class="carousel-control-next" href="#repair" data-slide="next">
<span class="carousel-control-next-icon"></span>
</a>
</div>
<!--Planned Linked Categories-->
<br>
<h2>Biggest Deals</h2>
<h2>What Just Came In</h2>
<h2>Most Shopped Categories</h2>
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