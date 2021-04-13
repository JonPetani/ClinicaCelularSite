<?php
public class ShoppingCart {
	private $account = '';
	private $items = array();
	
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
	
	function getCartItems() {
		return $items;
	}
	
	function addItem(Product $product) {
		array_push($items, $product);
	}
	
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