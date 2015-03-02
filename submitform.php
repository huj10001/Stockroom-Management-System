<html>
<head>                
<?php
    session_start();
    if (isset($_SESSION['user'])) {
        //print_r($_SESSION);
    }
?>


   	<?php
        error_reporting(1);
        require_once("secure_connect.php");
        $user = "root";
        $pass = "root";
        $result = "";
        $uID = "";
        $pID = "";
        
        $itemIDArray = array();
        $qtyArray = array();
        $priceArray = array();

       	if($stmt = $mysqli -> prepare("SELECT project_id from project_member where user_id=?")){
	       	$stmt -> bind_param("s", $_SESSION['user']['id']);
	       	$stmt -> execute();
	       	$stmt -> bind_result($project_id);
	       	while($stmt->fetch()){
	       		$pID = $project_id;
	       	}
       	}

       	$uID =  $_SESSION['user']['id'];

       	if($stmt = $mysqli -> prepare("INSERT INTO inventory.order(user_id, project_id) values (?,?);")){
       		$stmt -> bind_param("ii", $uID, $pID);
       		$stmt -> execute();
       	}
	    else{
	       	echo "prepare failed";
	       	mysqli_report(MYSQLI_REPORT_ALL);
	       	print_r($mysqli->error);
	    }

	    echo "you have successfully order:";
	    if($stmt = $mysqli -> prepare("SELECT * FROM item")) {                  
            $stmt -> execute();
            $stmt -> bind_result($id, $name, $description, $type, $qty, $price, $enabled);
            $count = 0;
			while ($stmt->fetch()) {
                array_push($itemIDArray, $id);               
                echo $name;
                echo " ";
                echo $_POST[$id];
                array_push($qtyArray, $_POST[$id]);
                array_push($priceArray, $price);
                echo "<br>";
                $count = $count + 1;
       		}
      	}

      	if($stmt = $mysqli -> prepare("SELECT id FROM inventory.order where user_id=?")) {
            $stmt -> bind_param("s", $_SESSION['user']['id']);
            $stmt -> execute();
            $stmt -> bind_result($id);
            while($stmt->fetch()){
                $orderID = $id;
            }
        }
        else{
	       		echo "prepare failed";
			   	mysqli_report(MYSQLI_REPORT_ALL);
			   	print_r($mysqli->error);
	    }

         for($i = 0; $i <= $count; $i++){
	         if($stmt = $mysqli -> prepare("INSERT INTO inventory.order_item(item_id, order_id, qty, price) values(?,?,?,?)")){
			     $itemID = array_pop($itemIDArray);
			     $quantity = array_pop($qtyArray);
			     $itemPrice = array_pop($priceArray);

			     $stmt -> bind_param("iiid", $itemID, $orderID, $quantity, $itemPrice);
				 $stmt -> execute();
	        	}
	   	    	else{
	        		echo "prepare failed";
			   		mysqli_report(MYSQLI_REPORT_ALL);
			  		print_r($mysqli->error);
	        	}
	    }
	?>

<head>
<script>
setTimeout('Redirect()', 5000);

function Redirect() {
    window.location = "secure_mainpage.php";
}
</script>
</head>
</html>
                       
</body>
</html>