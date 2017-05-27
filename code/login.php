<?php


session_start();


$myfile = fopen("../data/students.txt", "r") or die("Unable to open file!");


while(!feof($myfile)) {
  $studentsArray[] = explode(' ', fgets($myfile));
}
fclose($myfile);


if(ISSET($_POST["finaid_user"])){


	for($j = 0; $j < count($studentsArray); $j++){

		if(strcmp($studentsArray[$j][2], $_POST["finaid_user"]) == 0 && strcmp($studentsArray[$j][3], $_POST["finaid_password"]) == 0){
			$_SESSION["finaid_user"] = $_POST["finaid_user"];
			$_SESSION["finaid_password"] = $_POST["finaid_password"];
			header('Location: ' . 'http://' . $_SERVER['HTTP_HOST'] . '/nmurphy1/bookstore/payment?finaid=1');
			die("");
		}
	}


	header('Location: ' . 'http://' . $_SERVER['HTTP_HOST'] . '/nmurphy1/bookstore/payment?finaid=2');
	die("");


}
else{

	header('Location: ' . 'http://' . $_SERVER['HTTP_HOST'] . '/nmurphy1/bookstore/payment');
	die("Invalid");

}






?>