<?php
header('Content-Type: text/html; charset=UTF-8');
setlocale(LC_MONETARY,"en_US");

$type = 1;
if(ISSET($_GET["type"])){
	$type = $_GET["type"];
}

$pagetitle = "KSU Bookstore";
include_once("sections/header.php");
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

	<div class="col-xs-2 col-xs-offset-4 text-right">
		<select name="sort" class="form-control" onchange="sortResults(this.value)">
			<option value="" disabled selected>[Sort By]</option>
			<option value="0">A - Z</option>
			<option value="1">Z - A</option>
			<option value="2">Price, Low to High</option>
			<option value="3">Price, High to Low</option>
		</select>
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

$resultsArray = array();

//Loop through each line of the CSV
foreach ($arrayOfBooks as $bookLine){

	//2nd column contains the title - if our search term is in it, we extract title, image, and description
	if( stripos($bookLine[$type], $_GET["search"]) !== false){

		$entry = array();
		$highestPrice = 0;
		$lowestPrice = 10000;

		$entry[0] = $bookLine[0]; //ID
		$entry[1] = "{$bookLine[1]}"; //Title
		$entry[2] = " <b>ISBN: </b>{$bookLine[0]}";
		$entry[3] = "<img class='searchIcon' src='images/{$bookLine[0]}.jpg' title='{$bookLine[1]}'>";

		if(strlen($bookLine[17]) > 350){
			$bookLine[17] = substr($bookLine[17], 0, 350) . "[<i>...</i>]";
		}
		$entry[4] = "<p>" . utf8_encode($bookLine[17]) . "</p>"; //Description

		if(strtoupper($bookLine[2]) != "BLANK"){
			$entry[5] = "by " . $bookLine[2];
		}
		else{
			$entry[5] = " ";
		}

		$quantityString = "New: ";
		$quantityString .= "<b>" . processQuantity($bookLine[9]) . "</b>";
		if(processQuantity($bookLine[9]) != "OUT OF STOCK" && $bookLine[9] > 0){
			$quantityString .= " for <u> " . money_format("$%!n", $bookLine[13]) . "</u> | ";
		}
		else{
			$quantityString .= " | ";
		}
 
		$quantityString .= "Used: ";
		$quantityString .= "<b>" . processQuantity($bookLine[10]) . "</b>";
		if(processQuantity($bookLine[10]) != "OUT OF STOCK" && $bookLine[10] > 0){
			$quantityString .= " for <u> " . money_format("$%!n", $bookLine[14]) . "</u> | ";
		}
		else{
			$quantityString .= " | ";
		}

		$quantityString .= "Rental: ";
		$quantityString .= "<b>" . processQuantity($bookLine[11]) . "</b>";
		if(processQuantity($bookLine[11]) != "OUT OF STOCK" && $bookLine[11] > 0){
			$quantityString .= " for <u> " . money_format("$%!n", $bookLine[15]) . "</u> | ";
		}
		else{
			$quantityString .= " | ";
		}

		$quantityString .= "eBook: ";
		if($bookLine[12] > 0){
			$quantityString .= "<b>Available</b> for <u> " . money_format("$%!n", $bookLine[16]) . "</u>";
		}
		else{
			$quantityString .= "<b>Not Available</b>";
		}
		
		$entry[6] = "<span class='largerFont'>{$quantityString}</span>";


		//Get the highest/lowest price for sorting purposes
		for($h = 13; $h < 17; $h++){
			if($bookLine[$h - 4] > 0){ //Don't show out-of-stock prices
			if($bookLine[$h] > $highestPrice){
				$highestPrice = $bookLine[$h];
			}
			if($bookLine[$h] < $lowestPrice){
				$lowestPrice = $bookLine[$h];
			}
			}
		}
		$entry[7] = $highestPrice;
		$entry[8] = $lowestPrice;
		if(stripos($bookLine[8], "Required") !== false){	
			$entry[9] = "<b style='font-size:larger'>" . $bookLine[8] . "</b>"; //Recommended
		}
		else{
			$entry[9] = "<i>" . $bookLine[8] . "</i>"; 
		}

		$entry[9] .= " for Dr. {$bookLine[6]}'s <u>{$bookLine[4]}</u>, section {$bookLine[5]}"; 


		$resultsArray[] = $entry;
	}

}


//If we found something
if(count($resultsArray) > 0){



	//TODO: Make more flexible
	if($_GET["sort"] == 0){ //A-Z

		$sortByTextbook = array();
		foreach ($resultsArray as $textbooks) {    
			$sortByTextbook[] = $textbooks[1];
		}

		array_multisort($resultsArray, SORT_ASC, SORT_LOCALE_STRING, $sortByTextbook);
	}
	else if($_GET["sort"] == 1){ //Z-A

		$sortByTextbook = array();
		foreach ($resultsArray as $textbooks) {    
			$sortByTextbook[] = $textbooks[1];
		}

		array_multisort($resultsArray, SORT_DESC, SORT_LOCALE_STRING, $sortByTextbook);
		$resultsArray = array_reverse($resultsArray);
	}
	else if($_GET["sort"] == 2){ //Lowest to Highest Price

		$sortByPrice = array();
		foreach ($resultsArray as $prices) {    
			$sortByPrice[] = $prices[8];
		}

		array_multisort($resultsArray, SORT_ASC, SORT_NUMERIC, $sortByPrice);
	}
	else if($_GET["sort"] == 3){ //Highest to Lowest Price

		$sortByPrice = array();
		foreach ($resultsArray as $prices) {    
			$sortByPrice[] = $prices[7];
		}


		array_multisort($resultsArray, SORT_ASC, SORT_NUMERIC, $sortByPrice);
		$resultsArray = array_reverse($resultsArray);
		
	}







	echo "We found <b>" . count($resultsArray) . "</b> result(s):";
	echo "<hr class='clearfix'>";

	//Display results
	for($i = 0; $i < count($resultsArray); $i++){

		?>

		<div class="row">
			<div class="col-xs-2">
				<a href="details?id=<?php echo $resultsArray[$i][0]; ?>"><?php echo $resultsArray[$i][3];?></a>
			</div>
		
			<div class="col-xs-9 text-left">
				<h2><a href="details?id=<?php echo $resultsArray[$i][0]; ?>"><?php echo $resultsArray[$i][1]; ?></a></h2>
				<?php echo $resultsArray[$i][5]; ?>
				<?php echo $resultsArray[$i][2]; ?>
				<br><br>

				<?php
				echo $resultsArray[$i][4];
				?>
				<br>
				<?php echo $resultsArray[$i][9]; ?>
				<hr>
				<?php echo $resultsArray[$i][6]; ?>
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


<script>
function sortResults(sortvalue){

	window.location.href = "results?search=<?php echo str_replace(" ", "+", $_GET["search"]); ?>&type=<?php echo $type; ?>&sort=" + sortvalue;
}
</script>

<?php



include_once("sections/footer.php");
?>