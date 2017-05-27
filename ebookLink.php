<?php
	$pagetitle = "Ebook Download";
	include_once("sections/header.php");
?>
<?php

/*
function getGUID(){ //Creates GUID
    if (function_exists('com_create_guid')){
        return com_create_guid();
    }else{
        mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $hyphen = chr(45);// "-"
        $uuid = substr($charid, 0, 8).$hyphen
            .substr($charid, 8, 4).$hyphen
            .substr($charid,12, 4).$hyphen
            .substr($charid,16, 4).$hyphen
            .substr($charid,20,12);
        return $uuid;
    }
}
*/
?>
	<div class="col-xs-8 col-xs-offset-2 text-center">
		<?php
			$GUID = $_GET["GUID"];
		?>
		<br><br>
		<h1>Your Ebook has been downloaded!<br>GUID Number: <?php echo $GUID; ?></h1> 
	</div>

	

<?php
	include_once("sections/footer.php");
?>