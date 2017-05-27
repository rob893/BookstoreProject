<?php

session_start();


$database = "books.csv";
if(!file_exists($database)){
	$database = "../books.csv";
}

	$arrayOfBooks = array_map('str_getcsv', file($database));



$cartlabels = array("New", "Used", "Rental", "eBook");

$order = array();
$totalItems = 0;

if(count($_SESSION["cart"]) > 0 && !ISSET($nocart)){
	foreach ($_SESSION["cart"] as $orderLine){
		$order[] = explode(",", $orderLine);
		$totalItems += $order[count($order) - 1][2];
	}
}

?>


<button class="btn btn-info btn-lg text-center dropdown-toggle" data-toggle='dropdown'>
	Shopping Cart (<?php echo $totalItems; ?>) <span class="glyphicon glyphicon-chevron-down"></span>
</button>
	<div class='dropdown-menu dropdown-menu-right'>

<table class="table table-striped">

	<tr>
		<th>
		Item
		</th>
		<th>
		Type
		</th>
		<th>
		Quantity
		</th>

	</tr>

		
<?php


$cart_count = 0;
foreach ($order as $cartValues){

	echo "<tr>";

	

	$bookArray = array();
	foreach ($arrayOfBooks as $bookLine){
	
		if($bookLine[0] == $cartValues[0]){
			$bookArray = $bookLine;
		}

	}

	
	echo "<td>{$bookArray[1]}</td>";

	echo "<td>{$cartlabels[$cartValues[1]]}</td>";

	echo "<td>";
		echo "<input type='number' id='cartvalue$cart_count' value='{$cartValues[2]}' min='0' max='{$bookArray[9 + $cartValues[1]]}'>";
		echo "<input type='hidden' id='carttype$cart_count' value='{$cartValues[1]}'>";
		echo "<input type='hidden' id='cartid$cart_count' value='{$cartValues[0]}'>";
	echo "</td>";



	echo "</tr>";

	$cart_count++;
}


?>

		</td>
	</tr>


	<tr>

<?php
	if(count($_SESSION["cart"]) > 0){
?>
		<td colspan="2" class="text-center">
			<button id="updatecart" class="btn btn-default">Update Cart</button>
		</td> 

		<td>
			<a class="btn btn-default" href="checkout">Checkout</a>
		</td>

		</tr>
		<tr>
			<td colspan="3">
				<a href="shoppingcart" class="largerFont"><b>Go to your Shopping Cart  </b></a>
			</td>
		</tr>

<?php
}
else{
	echo "<td colspan='3' class='text-center'><b>Nothing in Cart!</b></td>";

}
?>

	</tr>
</table>

</div>