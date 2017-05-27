<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<link rel="stylesheet" href="css/bootstrap.min.css">


<script>

$( document ).ready(function() {
    	$("#updatecart").click(function(){
    		var i = 0;
		var updateString = "";
		var separator = "";

		while($("#cartvalue" + i).length != 0){
			
			if($("#cartvalue" + i).val() > 0){

				updateString += separator + $("#cartid" + i).val() + "," + $("#carttype" + i).val() + "," + $("#cartvalue" + i).val();
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
                   		document.getElementById("shopping_cart_section").innerHTML = data;
				location.reload();
                	}
            		},
            		error: function (xhr, desc, err){}
        	}); // end ajax call

		
	});
});

</script>
</body>
</html>