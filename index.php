<?php
$pagetitle = "KSU Bookstore";
include_once("sections/header.php");
?>




<div id="content" class="text-center spaceFromTop"">

<h1>KSU Bookstore</h1>

<hr>

<form method="get" action="results" class="col-xs-4 col-xs-offset-4">
	
	<div class="form-group text-left col-md-9">
  		<input name="search" class="form-control glyphicon" type="search" placeholder="&#57347; Keyword..."/>
	</div>
	<div class="form-group text-center col-md-3">
		<input type="submit" class="btn btn-default btn-lg" value="Search">
	</div>


	<div class="form-group text-left col-md-3">
		<label class="PhilosopherBoldItalic textSize5">Search by:</label>
	</div>
	<div class="form-group text-left col-md-6">
		<select class="form-control " name="type" id="type">
			<option value="1">Title</option>
			<option value="2">Author</option>
			<option value="17">Description</option>
			<option value="4">Course</option>
			<option value="6">Professor</option>
			<option value="0">ISBN</option>
		</select>
	</div>
	
	

	

<!--
	<div class="form-group text-left col-md-2">
		<label class="PhilosopherBoldItalic textSize5">Professor:</label>
	</div>
	<div class="form-group text-left col-md-4">
		<select class="form-control" name="Professor">
		<option> </option>
<?php
	$arrayOfBooks = array_map('str_getcsv', file('books.csv'));
	foreach($arrayOfBooks as $book){
		$professor[] = $book[6];
	}

	$professor = array_unique($professor);
	sort($professor);
	foreach($professor as $thisProfessor){
		echo '<option>'. $thisProfessor .'</option>';
	}
?>
		</select>
	</div>
		
	<div class="form-group text-left col-md-2">
		<label class="PhilosopherBoldItalic textSize5">Course:</label>
	</div>
	<div class="form-group text-left col-md-4">
		<select class="form-control" name="Course">
		<option> </option>
<?php
	$arrayOfBooks = array_map('str_getcsv', file('books.csv'));
	foreach($arrayOfBooks as $book){
		$course[] = $book[4];
	}

	$course = array_unique($course);
	sort($course);
	foreach($course as $thisCourse){
		echo '<option>'. $thisCourse .'</option>';
	}
?>
		</select>
	</div>

-->
	
	
</form>






</div>





<?php
include_once("sections/footer.php");
?>