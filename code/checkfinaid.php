<?php
session_start();
setlocale(LC_MONETARY,"en_US");


$myfile = fopen("data/students.txt", "r") or die("Unable to open file!");
$studentsString = "";


while(!feof($myfile)) {
  $studentsArray[] = explode(' ', fgets($myfile));
}
fclose($myfile);




if(ISSET($_SESSION["finaid_user"])){

	$funds = 0;
	for($i = 0; $i < count($studentsArray); $i++){
		if(strcmp($studentsArray[$i][2], $_SESSION["finaid_user"]) == 0){
			$funds = $studentsArray[$i][4];
			break;
		}
	}

?>


<h1>Financial Aid Summary</h1>

<form method="post" action="code/receipt">
<table class="table">
	<tr>
		<td class="text-left"><b>Total Cost</b></td>
		<td><?php echo money_format("$%!n", $_SESSION["ordertotal"]); ?></td>
	</tr>

	<tr>
		<td class="text-left"><b>Total Financial Aid</b></td>
		<td><?php echo money_format("$%!n", $funds); ?></td>
	</tr>

	<tr>
		<td> </td>
		<td> </td>
	</tr>

		<tr>
		<td class="largerFont text-left"><b>Total Financial Aid After Payment</b></td>
		<td><?php echo money_format("$%!n", $funds - $_SESSION["ordertotal"]); ?></td>
	</tr>

</table>

	<?php
		if($funds - $_SESSION["ordertotal"] > 0){
	?>
	<input type="submit" class="btn btn-info btn-lg" value="Pay">
	<?php
		}
	?>
	</form>


<?php
}
else{
?>


<h1>Financial Aid Login</h1>

<form method="post" action="code/login">
    	<div class="form-group text-left col-md-4">
		<label class="PhilosopherBoldItalic textSize5">User Name:</label>
	</div>
	<div class="form-group text-left col-md-8">
		<input type="text" class="form-control" name="finaid_user" required>
	</div>

	<div class="form-group text-left col-md-4">
		<label class="PhilosopherBoldItalic textSize5">Password:</label>
	</div>
	<div class="form-group text-left col-md-8">
		<input type="password" class="form-control" name="finaid_password" required>
	</div>


	<input type="submit" class="btn btn-info btn-lg" value="Login">
	</form>

<?php
}
?>