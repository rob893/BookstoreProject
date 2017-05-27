<?php
session_start();
setlocale(LC_MONETARY,"en_US");

$arrayOfBooks = array_map('str_getcsv', file('books.csv'));
$cartlabels = array("New", "Used", "Rental", "eBook");


$physicalFlag = 0;
$rentalFlag = 0;
$finalSales = 0;

$booksDataArray = array();
$finalorder = array();
$orderKeys = array();

if(count($_SESSION["cart"]) > 0){
	foreach ($_SESSION["cart"] as $orderLine){
		$finalorder[] = explode(",", $orderLine);
	}
}


foreach ($arrayOfBooks as $bookLine){

	foreach ($finalorder as $data){
		if($bookLine[0] == $data[0]){
			
			$orderKeys[] = count($booksDataArray);
			$booksDataArray[] = $bookLine;
			

		}
	}
}

//Copy all session data here
$userInfo = $_SESSION;

//Clearing out session


$pagetitle = "KSU Bookstore - Confirmation";
$nocart = 1;
include_once("sections/header.php");

?>



<div id="content">

<?php
	include_once("code/displayreceipt.php");
?>

</div>




<?php

$_SESSION = array();

include_once("sections/footer.php");
?>