<?php
session_start();

//Subtract from financial aid
if(ISSET($_SESSION["finaid_user"])){


	$myfile = fopen("../data/students.txt", "r") or die("Unable to open file!");

	while(!feof($myfile)) {
  		$studentsArray[] = explode(' ', fgets($myfile));
	}
	fclose($myfile);


	$newStudentRecords = "";
	for($i = 0; $i < count($studentsArray); $i++){
		if(strcmp($studentsArray[$i][2], $_SESSION["finaid_user"]) == 0){
			$studentsArray[$i][4] = $studentsArray[$i][4] - $_SESSION["ordertotal"];
		}


	$newStudentRecords .= $studentsArray[$i][0] . " " . $studentsArray[$i][1] . " " . $studentsArray[$i][2] . " " . $studentsArray[$i][3] . " " . trim($studentsArray[$i][4]) . "\n";
	}

	//write
	$mywfile = fopen("../data/students.txt", "w") or die("Unable to open file!");
	fwrite($mywfile, trim($newStudentRecords));
	fclose($mywfile);
}


//===============================================
//Subtract from Inventory

$arrayOfBooks = array_map('str_getcsv', file('../books.csv'));

foreach ($_SESSION["cart"] as $orderLine){
	$order[] = explode(",", $orderLine);	
}


//Updating
for($i = 0; $i < count($arrayOfBooks); $i++){

	foreach($order as $orderLine){
		if($orderLine[0] == $arrayOfBooks[$i][0] && $orderLine[1] != 3){ //Don't update eBooks quantity
			
			//Removing quantity from that section
			$arrayOfBooks[$i][9 + $orderLine[1]] = $arrayOfBooks[$i][9 + $orderLine[1]] - $orderLine[2];
			
		}
	}
}


//Actually writing
$csvfile = fopen("../books.csv","w");
foreach ($arrayOfBooks as $bookLine) {
       fputcsv($csvfile, $bookLine);
 }
fclose($csvfile);




//================================================
//Send Email

$email_from = "spsu_bookstore@spsu.edu";
$email_to = $_SESSION["shipping-billing"]["email_s"];
$email_subject = "SPSU Bookstore - Group Project Test";



//=====================================
$cartlabels = array("New", "Used", "Rental", "eBook");

$physicalFlag = 0;
$rentalFlag = 0;
$finalSales = 0;

$booksDataArray = array();
$finalorder = array();
$orderKeys = array();

foreach ($_SESSION["cart"] as $orderLine){
	$finalorder[] = explode(",", $orderLine);
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
//=====================================


//Save receipt data to email body
ob_start();
include 'displayreceipt.php';
$body = ob_get_contents();
ob_end_clean();


$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= 'From: '.$email_from."\r\n".
'Reply-To: '.$email_from."\r\n" .
'X-Mailer: PHP/' . phpversion();

@mail($email_to, $email_subject, $body, $headers); 



//=================================================
//Redirect


header('Location: ' . 'http://' . $_SERVER['HTTP_HOST'] . '/nmurphy1/bookstore/confirmation');
die("Invalid");

?>