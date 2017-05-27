<div class="col-xs-8 col-xs-offset-2">

<h1 class="text-left">Your Order has been placed!</h1>

<?php
	$cartlabels = array("New", "Used", "Rental", "eBook");
?>

<div class="row">
	<div class="col-xs-6 text-left">
		Congratulations! You just spent a lot of money on textbooks!
	</div>
	<div class="col-xs-6 text-center">
		Date of Purchase: <?php echo date("d/m/Y"); ?>
	</div>
</div>

<br class="clearfix">

<div class="row">
	<div class="col-xs-6 text-left">
		<p>Your receipt has been emailed to you.</p>
		<p>Shipping:</p>
		<?php
			echo $userInfo["shipping-billing"]["firstname_s"] . " " . $userInfo["shipping-billing"]["lastname_s"] . "<br>";
			echo $userInfo["shipping-billing"]["street_s"] . "<br>";
			echo $userInfo["shipping-billing"]["city_s"] . ", " . $userInfo["shipping-billing"]["state_s"] . " " . $userInfo["shipping-billing"]["zipcode_s"] . "<br>";

		?>

	</div>
	<div class="col-xs-6 text-center">
		
	</div>
</div>

<table class="table table-striped">
<tr>
	<th>Item</th>
	<th>Type</th>
	<th>Quantity</th>
	<th>Price</th>

</tr>

<?php

for($i = 0; $i < count($finalorder); $i++){

	?>

<tr>
	<td class="text-left"><?php echo $booksDataArray[$orderKeys[$i]][1]; ?></td>
	<td class="text-left"><?php echo $cartlabels[$finalorder[$i][1]]; ?></td>
	<td class="text-left"><?php echo $finalorder[$i][2]; ?></td>
	<td class="text-left"><?php echo money_format("$%!n", $finalorder[$i][2] * $booksDataArray[$orderKeys[$i]][13 + $finalorder[$i][1]]); ?></td>

	<?php

		if($finalorder[$i][1] != 3){ //If we've ordered at least one physical book
			$physicalFlag = 1;
		}
		if($finalorder[$i][1] == 2){ //Rental
			$rentalFlag = 1;
		}
		if($finalorder[$i][1] == 3){ //Ebook
			$ebookderpFlag = 1;
		}
		$finalSales += $finalorder[$i][2] * $booksDataArray[$orderKeys[$i]][13 + $finalorder[$i][1]];
	?>


</tr>

<?php

}


?>

</table>





<div class="col-xs-8 text-left">
Rental Due Date: <?php
if($rentalFlag == 1){
	echo "14/08/2017";
}
else{
	echo "N/A";
}

?>
<br><br>
EBook Download Link:
<?php
	if($ebookderpFlag == 1){
		$GUID = sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));

		echo "<a href=\"http://www.hhcard.org/nmurphy1/bookstore/ebookLink?GUID=$GUID\">Download your ebook here!</a>";
	} else {
		echo 'N/A';
	}
?>
</div>


<div class="col-xs-4">
<table class="table">
<tr>
	<td class="largerFont text-left"><b>Subtotal</b></td>
	<td class="largerFont text-center"><?php echo money_format("$%!n", $finalSales); ?></td>
</tr>
<tr>
	<td class="largerFont text-left"><b>Tax (7%)</b></td>
	<td class="largerFont text-center">
	<?php 
		echo "+" . money_format("$%!n", $finalSales * 0.07);
		$finalSales *= 1.07; 
	?>
	</td>
</tr>
<?php
if($physicalFlag == 1){
	$finalSales += 14.99;
?>
<tr>
	<td class="largerFont text-left"><b>Shipping</b></td>
	<td class="largerFont text-center">+$14.99</td>
</tr>
<?php
}
?>

<tr>
	<td> </td>
	<td> </td>
<tr>

<tr>
	<td class="largerFont text-left"><b class="largerFont">Total:</b></td>
	<td class="largerFont text-center"><b><?php echo money_format("$%!n", $finalSales); ?></b></td>
</tr>

</table>
</div>

</div>