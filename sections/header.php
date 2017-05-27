<!DOCTYPE html>
<html lang="en-US">
<head>
<meta charset="UTF-8">
<title><?php echo $pagetitle; ?></title>
<link rel="icon" type="image/png" href="/nmurphy1/bookstore/favicon.ico">
<link href="css/bootstrap.min.css" type="text/css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Nunito:400,400i,700" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:700" rel="stylesheet">
<link href="css/bookstore.css" type="text/css" rel="stylesheet">
</head>

<body class="text-center">



<div class="row" id="header">
	<div class="col-xs-4">
	<p class="tab">
		<a href="/nmurphy1/bookstore/">Home</a>
	</p>
	<p class="tab">
		<a href="faqs">FAQs</a>
	</p>
	</div>


	<div class="col-xs-4 text-center">
		<img src="images/ksu.png" id="ksulogo" alt="KSU Logo">
	</div>


	<div class="col-xs-4 text-right dropdown" id="shopping_cart_section">	
		<?php include_once("code/displaycart.php"); ?>
	</div>

</div>