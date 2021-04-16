<?php
/*
Programmer: Jonathan Petani
Date: April 2020 - April 2021
Purpose: The DB Connection File. Any Page That Needs A Database Query Calls This
*/
session_start();
$con = new PDO("mysql:host=localhost:3306;dbname=clinicacelular", "SimonJacinto", "TacoThursdaes");
$con -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
if(!isset($con))
	throw new Exception("Connection Failed");
?>