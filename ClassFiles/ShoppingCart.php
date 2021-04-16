<?php
/*
Programmer: Jonathan Petani
Date: April 2020 - April 2021
Purpose: E-Commerce Cart Object Class
*/
public class ShoppingCart {
	private $account = ''; //Account STR
	private $items = array(); //Items In Product Cart
	
	//Constructor
	function __construct(string $account, object $con) {
		$sql = $con -> prepare('SELECT * FROM customer WHERE EmailAddress = :addr');
		$sql -> bindParam(':addr', $account);
		$sql -> execute();
		if($sql -> rowCount() < 1) {
			header("store.php?error=noaccount");
			die;
		}
		unset($sql);
		$this -> account = $account;
	}
	
	//Setters and Getters
	
	//EmailAddress Of Cart's Customer Account
	function setAccountIdentifier(string $account, object $con) {
		$sql = $con -> prepare('SELECT * FROM customer WHERE EmailAddress = :addr');
		$sql -> bindParam(':addr', $account);
		$sql -> execute();
		if($sql -> rowCount() < 1) {
			header("store.php?error=noaccount");
			die;
		}
		unset($sql);
		$this -> account = $account;
	}
	
	function getAccountIdentifier() {
		return $account;
	}
	
	//Get All Items In Cart Currently
	function getCartItems() {
		return $items;
	}
	
	//Append A New Product (When User Presses Add To Cart Link On Store Pages)
	function addItem(Product $product) {
		array_push($items, $product);
	}
	
	//Delete Item From Cart That Customer No Longer Wants To Purchase
	function deleteItem(string $product) {
		for($i = 0; $i < sizeof($items); $i++) {
			if(strcmp($items[$i] -> getName(), $product) == 0) {
				unset($items[$i]);
				break;
			}
		}
	}
	
}
?>