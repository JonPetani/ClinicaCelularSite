<?php
session_start();
$con = new PDO("mysql:host=localhost:3306;dbname=clinicacelular", "SimonJacinto", "TacoThursdaes");
if(!isset($con))
	throw new Exception("Connection Failed");
?>