<?php
session_start();
$con = new PDO("mysql:host=localhost:3306;dbname=clinicacelular", "SimonJacinto", "TacoThursdaes");
$con -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
if(!isset($con))
	throw new Exception("Connection Failed");
?>