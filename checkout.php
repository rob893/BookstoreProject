<?php
session_start();
setlocale(LC_MONETARY,"en_US");

$pagetitle = "KSU Bookstore - Checkout";
include_once("sections/header.php");


$arrayOfBooks = array_map('str_getcsv', file('books.csv'));
$cartlabels = array("New", "Used", "Rental", "eBook");


$physicalFlag = 0;
$finalSales = 0;

$booksDataArray = array();
$order = array();
$orderKeys = array();

foreach ($_SESSION["cart"] as $orderLine){
	$order[] = explode(",", $orderLine);
}

foreach ($arrayOfBooks as $bookLine){

	foreach ($order as $data){
		if($bookLine[0] == $data[0]){
			
			$orderKeys[] = count($booksDataArray);
			$booksDataArray[] = $bookLine;
			

		}
	}
}

?>



<div id="content">

<h1>Your Order Summary</h1>

<div class="col-xs-8 col-xs-offset-2">

<table class="table table-striped">
<tr>
	<th><!-- Image Goes Here --></th>
	<th>Textbook Title</th>
	<th>Type</th>
	<th>Quantity</th>
	<th>Per Unit Cost</th>
	<th>Total Cost</th>

</tr>

<?php

for($i = 0; $i < count($order); $i++){

	?>

<tr>
	<td><img src="images/<?php echo $order[$i][0]; ?>.jpg" class="checkoutIcon"></td>
	<td class="text-left"><?php echo $booksDataArray[$orderKeys[$i]][1]; ?></td>
	<td class="text-left"><?php echo $cartlabels[$order[$i][1]]; ?></td>
	<td class="text-left"><?php echo $order[$i][2]; ?></td>
	<td class="text-left"><?php echo money_format("$%!n", $booksDataArray[$orderKeys[$i]][13 + $order[$i][1]]); ?></td>
	<td class="text-left"><?php echo money_format("$%!n", $order[$i][2] * $booksDataArray[$orderKeys[$i]][13 + $order[$i][1]]); ?></td>

	<?php

		if($order[$i][1] != 3){ //If we've ordered at least one physical book
			$physicalFlag = 1;
		}
		$finalSales += $order[$i][2] * $booksDataArray[$orderKeys[$i]][13 + $order[$i][1]];
	?>


</tr>

<?php

}


?>

</table>




<table class="table">
<tr>
	<td class="largerFont text-left"><b>Subtotal</b></td>
	<td class="largerFont text-center"><?php echo money_format("$%!n", $finalSales); ?></td>
</tr>
<tr>
	<td class="largerFont text-left"><b>GA Sales Tax</b></td>
	<td class="largerFont text-center">
	<?php 
		echo "+" . money_format("$%!n", $finalSales * 0.07);
		$finalSales *= 1.07; 
	?>
	</td>
</tr>
<?php
if($physicalFlag == 1){
	$finalSales += 14.95;
?>
<tr>
	<td class="largerFont text-left"><b>Shipping & Handling</b></td>
	<td class="largerFont text-center">+$14.95</td>
</tr>
<?php
}
?>

<tr>
	<td> </td>
	<td> </td>
<tr>

<tr>
	<td class="largerFont text-left"><b>Total Cost</b></td>
	<td class="largerFont text-center"><b><?php echo money_format("$%!n", $finalSales); ?></b></td>
	<?php $_SESSION["ordertotal"] = $finalSales; ?>
</tr>

</table>



<a href="shipping" class="btn btn-info btn-lg">Pay Now</a>

</div>


</div>




<?php

//Storing this here since I'm lazy


include_once("sections/footer.php");
?>