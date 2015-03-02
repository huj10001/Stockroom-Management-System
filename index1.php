<!DOCTYPE html>
<html>
<body>
	<head>
		<h1>This is a table from the db</h1>
		<style>
			table{
    			border: 1px solid black;
    			border-collapse: collapse;
    			width:100%;
			}
			td{
				border: 1px solid black;
			}
		</style>
	</head>
	<div>
	<h2>General Supplies</h2>
	<table>
			<?php
			error_reporting(0);
			require_once("db_connect.php");
			$sql = "SELECT * FROM item";
			$result = mysql_query($sql) or die(mysql_error());
			echo("<table>");

			$row = mysql_fetch_array($result) or die(mysql_error());
			while($row = mysql_fetch_array($result)){ ?>
				<tr>
					<td align="center"> <?=$row['name']; ?> </td>
					<td align="center"> <?=$row['description']; ?> </td> 
					<td align="center"> <?=$row['qty']; ?> </td> 
					<td align="center"> <?=$row['price']; ?> </td>
					<td align="center"><input type="text" name=<?=$row['name'];?> placeholder="Enter Amount"></td>
				</tr>


			<?php };
				mysql_free_result($result);
			?>

	</table>
	</div>
	<tr id="tablefoot"><td>Total:</td><td colspan="2" id="totalerr"><td id="finaltotal"></td></tr>


	<script type="text/javascript">
	window.onerror = function(msg, url, linenumber) {
    alert('Error message: '+msg+'\nURL: '+url+'\nLine Number: '+linenumber);
    return true;	};


	function doTotals() {
    var names = 'name';
    var priceStr = 'price';
    var quantityStr = 'qty';
    // var subtotalStr = 'subtotal';
    var total = 0;
    for (var i = 0; i < names.length; i++) {
        var price = document.getElementById(names + priceStr).value;
        var quantity = document.getElementById(names + quantityStr).value;
        // document.getElementById(names[i] + subtotalStr)
        //     .innerHTML = parseInt(price) * parseInt(quantity);
        // total += price * quantity;
        total = price * quantity;
    }
    document.getElementById("finaltotal").innerHTML = total;
}
</body>
</html>