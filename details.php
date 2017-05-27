<?php


if(!ISSET($_GET["id"])){
	header('Location: ' . 'http://' . $_SERVER['HTTP_HOST'] . '/nmurphy1/bookstore/');
	die("Invalid ID");
}

$pagetitle = "KSU Bookstore";
include_once("sections/header.php");

//Get all matching items from shopping cart
$order = array();

if(count($_SESSION["cart"]) > 0){
	foreach ($_SESSION["cart"] as $orderLine){
		if (strpos($orderLine, $_GET["id"]) !== false) {
			$order[] = explode(",", $orderLine);
		}
	}
}

?>



<div id="content">


<?php


function processQuantity($textbookQuantity){

	if(strtoupper($textbookQuantity) == "INF"){
		return "UNLIMITED";
	}

	if($textbookQuantity <= 0){
		return "OUT OF STOCK";
	}

	return $textbookQuantity;

}


$arrayOfBooks = array();


//Super-useful - handles commas in quoted sections with no additional parsing
$arrayOfBooks = array_map('str_getcsv', file('books.csv'));

$imageArray = array();
$titleArray = array();
$authorArray = array();
$description = "";
$associated_courses = "";
$associated_professor="";

//New, Used, Rental, eBook
$quantities = array();
$prices = array();


//Loop through each line of the CSV
foreach ($arrayOfBooks as $bookLine){

	//2nd column contains the title - if our search term is in it, we extract title, image, and description
	if(strpos($bookLine[0], $_GET["id"]) !== false){
		$titleArray[] = "{$bookLine[1]}";
		$imageArray[] = "<img class='detailIcon' src='images/{$bookLine[0]}.jpg'>";
		$description = "<p>" . utf8_encode($bookLine[17]) . "</p>";
		$associated_courses = "{$bookLine[4]}";
		$associated_professor = "{$bookLine[6]}";
		$requiredRecommended = "{$bookLine[8]}";
		$courseSection = "{$bookLine[5]}";
		$ISBN = "{$bookLine[0]}";

		if(strtoupper($bookLine[2]) != "BLANK"){
			$authorArray[] = "by " . $bookLine[2];
		}
		else{
			$authorArray[] = " ";
		}

		
		for($i = 0; $i < 4; $i++){
			$quantities[] = $bookLine[9 + $i];
			$prices[] = $bookLine[13 + $i];
		}
				

		if($bookLine[12] == 999999){
			$quantityString .= "<b>Available</b>";
		}
		else{
			$quantityString .= "<b>Not Available</b>";
		}


		if(strtoupper($requiredRecommended) == "REQUIRED"){
			$requiredRecommended = "<b class='largerFont'>$requiredRecommended</b>";
		}
		else{
			$requiredRecommended = "<i>$requiredRecommended</i>";
		}
	}

}


//If we found something
if(count($titleArray) > 0){

	echo "<hr class='clearfix'>";

	//Display results
	for($i = 0; $i < count($titleArray); $i++){

		?>

		<div class="row">
			<div class="col-xs-10 col-xs-offset-1 text-left">
				<h2><?php echo $titleArray[$i]; ?></h2>
				<?php echo $authorArray[$i]; ?>
			</div>

		</div>
		<div class="row">
			<div class="col-xs-3 col-xs-offset-1">
				<?php echo $imageArray[$i];?>

				<p class="text-left">
					<b>ISBN</b>: <br>
					<?php echo $ISBN; ?>
					<br>
				</p>
				<h3 class="text-left">Related Courses:</h3>

				<p class="text-left">
					<?php
					echo $requiredRecommended . " for Dr. $associated_professor" . "'s <u>$associated_courses</u>, Section $courseSection";
					?>
					<br>
				</p>
				
					
			</div>
		
			<div class="col-xs-6 text-left">

			<div class="panel panel-default">
				
  				<div class="panel-heading">
					<h2>Select a Textbook Format</h2>
				</div>

  				<div class="panel-body">

				<form method="post" action="code/updatecart">
				
				<?php
					setlocale(LC_MONETARY,"en_US");
					$labels = array("New", "Used", "Rental", "eBook");
					for($i = 0; $i < 4; $i++){
		

				?>

						<div class="col-xs-3 radio">
						<?php
							$showCheckbox = 0;
							foreach($order as $checkQuantity){
								if($checkQuantity[1] == $i){
									$showCheckbox = $checkQuantity[2];
								}
							}

							if($showCheckbox < $quantities[$i]){
								echo "<input type='radio' name='booktype' value='{$i}' required> ";
							}

						?>
						<?php echo $labels[$i]; ?>
						</div>

						<div class="col-xs-8 text-right">
						<?php echo money_format("$%!n", $prices[$i]); ?>
						</div>
						

					<br class="clearfix">
					<hr>
				<?php
					}
				?>

		
				<input type="hidden" name="action" value="add">
				<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
				<input type="submit" class="btn btn-default" value="Add to Cart">

				</form>

				</div>

				
			</div>

				
				


				<?php echo '<p>Description:</p>'.$description; ?>

				
			</div>

		</div>
		<hr>

		<?php
		
	}
}
else{
	echo "No Results Found.";
	echo "<hr class='clearfix'>";

}


?>







</div>




<?php
include_once("sections/footer.php");
?>