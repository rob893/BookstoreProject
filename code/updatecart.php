<?php
session_start();



if(ISSET($_POST["action"])){

	if($_POST["action"] == "add"){

		$id = $_POST["id"];
		$booktype = $_POST["booktype"];
		$quantity = 1;

		$foundit = 0;
		for($i = 0; $i < count($_SESSION["cart"]); $i++){		
			if(strpos($_SESSION["cart"][$i], $id) !== false && strpos($_SESSION["cart"][$i], "," . $booktype . ",") !== false){
				
				$updateArray = explode(",", $_SESSION["cart"][$i]);
				$updateArray[2]++;
				$_SESSION["cart"][$i] = $updateArray[0] . "," . $updateArray[1] . "," . $updateArray[2];


				$foundit = 1;

			}
		}


		if($foundit == 0){
			$_SESSION["cart"][] = $id . "," . $booktype . "," . $quantity;
		}


		header('Location: ' . 'http://' . $_SERVER['HTTP_HOST'] . '/nmurphy1/bookstore/shoppingcart');
		die("Invalid ID");
	}
}


?>