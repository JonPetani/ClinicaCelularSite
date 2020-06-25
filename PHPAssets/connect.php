<?php
session_start();
$con = new PDO("mysql:host=clinicacelular;dbname=clinicacelular", "SimonJacinto", "tacothursdaes");
if(!isset($con))
	throw new Exception("Connection Failed");
?>