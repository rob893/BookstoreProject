<?php
session_start();
setlocale(LC_MONETARY,"en_US");

$pagetitle = "KSU Bookstore - Shipping";
include_once("sections/header.php");

?>



<div id="content">

<br><br>
<h1>Step 1: Shipping & Billing Options</h1>

<div class="row">

<form method="post" action="payment">
<div class="col-xs-5 col-xs-offset-1">

<h2>Shipping Address</h2>
<br><br><br>

	<div class="form-group text-left col-md-4">
		<label class="PhilosopherBoldItalic textSize5">First Name:</label>
	</div>
	<div class="form-group text-left col-md-8">
		<input type="text" class="form-control" name="firstname_s" title="Enter your first name." required>
	</div>

	<div class="form-group text-left col-md-4">
		<label class="PhilosopherBoldItalic textSize5">Last Name:</label>
	</div>
	<div class="form-group text-left col-md-8">
		<input type="text" class="form-control" name="lastname_s" title="Enter your last name." required>
	</div>

	<div class="form-group text-left col-md-4">
		<label class="PhilosopherBoldItalic textSize5">Email:</label>
	</div>
	<div class="form-group text-left col-md-8">
		<input type="email" class="form-control" name="email_s" title="Enter your email address." required>
	</div>

	<div class="form-group text-left col-md-4">
		<label class="PhilosopherBoldItalic textSize5">Street:</label>
	</div>
	<div class="form-group text-left col-md-8">
		<input type="text" class="form-control" name="street_s" title="Enter your complete street address." required>
	</div>

	<div class="form-group text-left col-md-4">
		<label class="PhilosopherBoldItalic textSize5">City:</label>
	</div>
	<div class="form-group text-left col-md-8">
		<input type="text" class="form-control" name="city_s" title="Enter your city." required>
	</div>


	<div class="form-group text-left col-md-4">
		<label class="PhilosopherBoldItalic textSize5">State:</label>
	</div>
	<div class="form-group text-left col-md-2">
		<select class="form-control" name="state_s" title="Enter your state." required>
			<?php include("code/states.php"); ?>
		</select>
	</div>
	<div class="form-group text-center col-md-3">
		<label class="PhilosopherBoldItalic textSize5">Zip Code:</label>
	</div>
	<div class="form-group text-left col-md-3">
		<input type="text" class="form-control" maxlength="5" name="zipcode_s" pattern="[0-9]{5}" title="Zip code must be 5 numbers." onkeyup="this.value=this.value.replace(/[^\d]/g,'')"  required>
	</div>


</div>



<div class="col-xs-5 col-xs-offset-1">

<h2>Billing Address</h2>

<input name="use_shipping" type="checkbox" data-toggle="collapse" data-target="#billcontainer" checked> <b>Use Shipping Address?</b>
<br><br>

	<div id="billcontainer" class="collapse">


	<div class="form-group text-left col-md-4">
		<label class="PhilosopherBoldItalic textSize5">First Name:</label>
	</div>
	<div class="form-group text-left col-md-8">
		<input type="text" class="form-control" name="firstname_b" title="Enter your first name.">
	</div>

	<div class="form-group text-left col-md-4">
		<label class="PhilosopherBoldItalic textSize5">Last Name:</label>
	</div>
	<div class="form-group text-left col-md-8">
		<input type="text" class="form-control" name="lastname_b" title="Enter your last name.">
	</div>

	<div class="form-group text-left col-md-4">
		<label class="PhilosopherBoldItalic textSize5">Email:</label>
	</div>
	<div class="form-group text-left col-md-8">
		<input type="email" class="form-control" name="email_b" title="Enter your email address.">
	</div>

	<div class="form-group text-left col-md-4">
		<label class="PhilosopherBoldItalic textSize5">Street:</label>
	</div>
	<div class="form-group text-left col-md-8">
		<input type="text" class="form-control" name="street_b" title="Enter your complete street address.">
	</div>

	<div class="form-group text-left col-md-4">
		<label class="PhilosopherBoldItalic textSize5">City:</label>
	</div>
	<div class="form-group text-left col-md-8">
		<input type="text" class="form-control" name="city_b" title="Enter your city.">
	</div>


	<div class="form-group text-left col-md-4">
		<label class="PhilosopherBoldItalic textSize5">State:</label>
	</div>
	<div class="form-group text-left col-md-2">
		<select class="form-control" name="state_b" title="Enter your state.">
			<?php include("code/states.php"); ?>
		</select>
	</div>
	<div class="form-group text-center col-md-3">
		<label class="PhilosopherBoldItalic textSize5">Zip Code:</label>
	</div>
	<div class="form-group text-left col-md-3">
		<input type="text" class="form-control" maxlength="5" name="zipcode_b" pattern="[0-9]{5}" title="Zip code must be 5 numbers." onkeyup="this.value=this.value.replace(/[^\d]/g,'')">
	</div>


	</div>
</div>
</div>


<div class="row">
	<hr>
	<button type="submit" class="btn btn-info btn-lg">Next</button>
</div>

</form>

</div>




<?php
include_once("sections/footer.php");
?>