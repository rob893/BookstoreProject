<?php
session_start();
setlocale(LC_MONETARY,"en_US");

$type = 1;
if(ISSET($_GET["type"])){
	$type = $_GET["type"];
}

$pagetitle = "KSU Bookstore - Shopping Cart";
include_once("sections/header.php");


$arrayOfBooks = array_map('str_getcsv', file('books.csv'));
$cartlabels = array("New", "Used", "Rental", "eBook");


$physicalFlag = 0;
$finalSales = 0;

$booksDataArray = array();
$order = array();
$orderKeys = array();

if(count($_SESSION["cart"]) > 0){
foreach ($_SESSION["cart"] as $orderLine){
	$order[] = explode(",", $orderLine);
}
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
 
<br>

<form method="get" action="results">

	<div class="text-left row">
	<div class="col-xs-3 col-xs-offset-1">
  	<input name="search" class="form-control glyphicon" type="search" placeholder="&#57347; Search Again"/>
	</div>	

	<div class="col-xs-2">
	<input type="submit" class="btn btn-default" value="Search">
	</div>

	</div>

	<br class="clearfix">

	<div class="text-left row">

		<div class="form-group text-left col-xs-1 col-xs-offset-1">
			<label class="PhilosopherBoldItalic textSize5">Search by:</label>
		</div>
		<div class="form-group text-left col-xs-2">
			<select class="form-control" name="type" id="type">
			<?php
				$searchlabels = array("Title", "Author", "Description", "Course", "Professor", "ISBN");	
				$searchid = array(1, 2, 17, 4, 6, 0);		

				for($j = 0; $j < count($searchlabels); $j++){

					$selected = "";
					if($type == $searchid[$j]){
						$selected = " selected";
					}
					echo "<option value='" . $searchid[$j]. "'$selected>" . $searchlabels[$j] . "</option>\n";
				}
			?>
			</select>
		</div>		

	</div>

	

</form>

<h1>Your Shopping Cart</h1>

<div class="col-xs-8 col-xs-offset-2">

<?php
if(count($order) > 0){
?>


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
	<td><a href="details?id=<?php echo $booksDataArray[$orderKeys[$i]][0]; ?>"><img src="images/<?php echo $order[$i][0]; ?>.jpg" title="<?php echo $booksDataArray[$orderKeys[$i]][1]; ?>" class="checkoutIcon"></a></td>
	<td class="text-left"><a href="details?id=<?php echo $booksDataArray[$orderKeys[$i]][0]; ?>"><?php echo $booksDataArray[$orderKeys[$i]][1]; ?></a></td>
	<td class="text-left"><?php echo $cartlabels[$order[$i][1]]; ?></td>
	<td class="text-left">
		<?php 
			echo "<input type='number' id='cartvalueS$i' value='{$order[$i][2]}' min='0' max='{$booksDataArray[$orderKeys[$i]][9 + $order[$i][1]]}'>";
			echo "<input type='hidden' id='carttypeS$i' value='{$order[$i][1]}'>";
			echo "<input type='hidden' id='cartidS$i' value='{$order[$i][0]}'>";

		?>
	</td>
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
</table>




<button id="updatecartS" class="btn btn-default">Update Cart</button>
<a href="checkout" class="btn btn-info btn-lg">Check Out</a>
</form>

<?php
}
else{

	echo "<br>Your Shopping Cart is Empty";
}

?>

</div>


</div>

<?php
include_once("sections/footer.php");
?>

<script>

$( document ).ready(function() {
    	$("#updatecartS").click(function(){
    		var i = 0;
		var updateString = "";
		var separator = "";

		while($("#cartvalueS" + i).length != 0){
			
			if($("#cartvalueS" + i).val() > 0){

				updateString += separator + $("#cartidS" + i).val() + "," + $("#carttypeS" + i).val() + "," + $("#cartvalueS" + i).val();
				separator = ";";
			}

			i++;
		}

	    	$.ajax({
            		url: 'code/updatequantity',
            		type: 'post',
            		data: { 'shoppingcart': updateString},
            		success: function (data, status)
            		{
                	if (status == "success")
                	{
                   		location.reload();
                	}
            		},
            		error: function (xhr, desc, err){}
        	}); // end ajax call

		
	});
});

</script>