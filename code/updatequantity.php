<?php

session_start();

$_SESSION = array();


$shoppingcart = $_POST["shoppingcart"];


$shoppingcartArray = explode(";", $shoppingcart);


if (strpos($shoppingcart, ';') === false) {
	$shoppingcartArray[0] = $shoppingcart;
}

if(strlen($shoppingcart) > 2){
	for($i = 0; $i < count($shoppingcartArray); $i++){
		$_SESSION["cart"][] = $shoppingcartArray[$i];
	}
}

include_once("displaycart.php");

?>