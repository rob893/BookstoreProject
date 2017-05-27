<?php
session_start();
setlocale(LC_MONETARY,"en_US");

$pagetitle = "KSU Bookstore - Payment";
include_once("sections/header.php");


//Save Shipping info
if(ISSET($_POST["firstname_s"])){
	$_SESSION['shipping-billing'] = $_POST;
}

$active = "";
if(ISSET($_GET["finaid"])){
	$active = "active ";
}

?>



<div id="content">

<h1>Step 2: Payment Options</h1>

<hr>

<div class="row">

<ul class="nav nav-tabs">
  <li class="col-md-2 col-md-offset-3 col-xs-12"><button class="btn btn-warning btn-lg" data-toggle="tab" href="#paypal">PayPal</button></li>
  <li class="col-md-2 col-xs-12"><button class="btn btn-secondary btn-lg" data-toggle="tab" href="#creditcard">Credit Card</button></li>
  <li class="<?php echo $active; ?>col-md-2 col-xs-12"><button class="btn btn-danger btn-lg" data-toggle="tab" href="#financialaid">Financial Aid</button></li>
</ul>

</div>

</hr>

<div class="tab-content">
  <div id="paypal" class="tab-pane fade col-xs-6 col-xs-offset-3">

	<br><br>
	<h2>PayPal</h2>

	<form method="post" action="code/receipt">
    	<div class="form-group text-left col-md-4">
		<label class="PhilosopherBoldItalic textSize5">User Name:</label>
	</div>
	<div class="form-group text-left col-md-8">
		<input type="text" class="form-control" name="paypaluser" title="Enter your PayPal user name." required>
	</div>

	<div class="form-group text-left col-md-4">
		<label class="PhilosopherBoldItalic textSize5">Password:</label>
	</div>
	<div class="form-group text-left col-md-8">
		<input type="password" class="form-control" name="paypalpassword" title="Enter your PayPal password." required>
	</div>

	<div class="form-group text-center col-md-12">
		<input type="submit" class="btn btn-info btn-lg" value="Pay">
	</div>
	</form>







  </div>
  <div id="creditcard" class="tab-pane fade col-xs-6 col-xs-offset-3">
    

	<br><br>
	<h2>Visa or MasterCard</h2>

	<form method="post" action="code/receipt">
	<div class="form-group text-left col-md-4">
		<label class="PhilosopherBoldItalic textSize5">Name on Card:</label>
	</div>
	<div class="form-group text-left col-md-8">
		<input type="text" class="form-control" name="nameoncard" title="Name as it appears on the card.")"  required>
	</div>
	
    <div class="form-group text-left col-md-4">
		<label class="PhilosopherBoldItalic textSize5">Card Number:</label>
	</div>
	<div class="form-group text-left col-md-8">
		<input type="text" class="form-control" maxlength="16" name="cardnumber" pattern="[0-9]{16}" title="Credit card must be 16 numbers." onkeyup="this.value=this.value.replace(/[^\d]/g,'')"  required>
	</div>


	<div class="form-group text-left col-md-4">
		<label class="PhilosopherBoldItalic textSize5">Exp. Date:</label>
	</div>
	<div class="form-group text-left col-md-4">
		<select type="text" class="form-control" style="max-width:5em !important; display:inline-block !important" name="expdate1" id="expdate1" onchange="checkExpiration()" required>
			<option> </option>
			<?php
			for($i = 1; $i <= 12; $i++){
				$display = $i;
				if($i < 10){
					$display = "0" . $i;
				}
				$selected = "";
				if($i == date('n')){
					$selected = " selected";
				}
				echo "<option value='$display'$selected>$display</option>";

			}
			?>
		</select>
		/
		<select type="text" class="form-control" style="max-width:5em !important; display:inline-block !important" name="expdate2" id="expdate2" onchange="checkExpiration()" required>
			<option value='17'>17</option>
			<?php
			for($i = 18; $i <= 32; $i++){
				echo "<option value='$i'>$i</option>";

			}
			?>
		</select>
	</div>
	<div class="form-group text-center col-md-2">
		<label class="PhilosopherBoldItalic textSize5">CVC:</label>
	</div>
	<div class="form-group text-left col-md-2">
		<input type="text" maxlength="3" class="form-control" name="cvc" pattern="[0-9]{3}" title="CVC must be 3 numbers" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" required>
	</div>

	<div class="form-group text-center col-md-12">
		<input type="submit" class="btn btn-info btn-lg" value="Pay">
	</div>
	</form>



  </div>
  <div id="financialaid" class="tab-pane fade in <?php echo $active; ?>col-xs-6 col-xs-offset-3">
  
	<br><br>
	<?php
		if($_GET["finaid"] > 1){
			echo "<b style='color:red; font-size:larger'>Invalid User Name and/or Password!</b>";
		}

	?>
	<?php include_once("code/checkfinaid.php"); ?>


  </div>
</div>



</div>


<script>

function checkExpiration(){

	var first = document.getElementById("expdate1");
	var second = document.getElementById("expdate2");

	if(second.value == 17){
		var d = new Date();
		var n = d.getMonth() + 1;
		if(first.value <= n){
			var n2 = n + 1;
			if(n2 < 10){
				n2 = "0" + n2;
			}
			first.value = n2;
		}
	}


}


</script>

<?php
include_once("sections/footer.php");
?>