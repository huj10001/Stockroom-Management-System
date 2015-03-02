
<?php
    session_start();
    if (isset($_SESSION['user'])) {
        //print_r($_SESSION);
    }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/css; charset=utf-8" />
    <title>Homepage</title>
    <link href="tabs.css" rel="stylesheet" type="text/css" />
    <style>
        table,th,td{
            border:1px solid black;
        }
        .innerDiv{
            float:left;
            margin-right:10px;
        }
        div{
            float:left;
        }
    </style>
    <script type="text/javascript">
        window.onerror = function(msg, url, linenumber) {
            alert('Error message: '+msg+'\nURL: '+url+'\nLine Number: '+linenumber);
            return true;
        };

        function doTotals() {
            var items = ['sfc_'];
            var priceStr = 'price';
            var quantityStr = 'qty';
            var subtotalStr = 'subtotal';
            var total = 0;
            for (var i = 0; i < items.length; i++) {
                var price = document.getElementById(items[i] + priceStr).value;
                var quantity = document.getElementById(items[i] + quantityStr).value;
                document.getElementById(items[i] + subtotalStr)
                    .innerHTML = parseInt(price) * parseInt(quantity);
                total += price * quantity;
            }
            document.getElementById("finaltotal").innerHTML = total;
        }

        function setup() {
            var lastCol = document.getElementById("subtotal_header");

            var theForm = document.getElementById("souvenirsorderform");

            var amounts = document.getElementsByTagName("select");
            for(var i = 0; i < amounts.length; i++){
                amounts[i].onchange = doTotals;
            }

            // theForm.onsubmit = validate;
        }

        window.onload = setup;

    </script>
<style>
    table{
                border: 1px solid black;
                border-collapse: collapse;
                width: 50%;
            }
            td{
                border: 1px solid black;
            }

    #logout {
                width: 10em;  height: 3em;
            }
</style>
</head>



<body>
<h1>My Homepage</h1>
<span style="display:inline;">You are logged in as <?php echo $_SESSION['user']['email']; ?></span>
<br>

<ol id="toc">
    <li><a href="#page-0"><span>HOME</span></a></li>
    <li><a href="#page-1"><span>BUY</span></a></li>
    <li><a href="#page-2"><span>PURCHASE HISTORY</span></a></li>
    <li><a href="#page-3"><span>FORUM</span></a></li>
    <li><a href="#page-4"><span>ACCOUNT</span></a></li>
    <!--<li><a href="#page-5"><span></span></a></li>-->
    <li></li>
    <li> <a href="logout.php"><span>LOGOUT</span></a></li> 
</ol>  

<div class="content" id="page-0" style="width: 60%;">

    <h2>Announcement</h2>

    <?php
        error_reporting(0);
        require_once("secure_connect.php");
        $user = "root";
        $pass = "root";
        $result = "";
        if($stmt = $mysqli -> prepare("SELECT * FROM Announcement")) {
            $stmt -> execute();
            $stmt -> bind_result($id, $note);
            while ($stmt->fetch()) { ?>
                <p><marquee behavior="scroll" direction="up" onmouseover="this.stop();" onmouseout="this.start();">
                <a href=" "> <?php echo $note; ?> </a>
                </marquee></p> 
    <?php }} ?>
</div>

<div class="content" id="page-1" style="width: 60%;">

    <h2>Buy Supplies</h2>
    <form action="submitForm.php" method="post" id="orderForm">
        <hr>
            <div>
                <div class="innerDiv">
                    <h2>General Supplies</h2>
                    <table>
                        <tr>
                            <th align="center">Name</th>
                            <th align="center">Description</th>
                            <th align="center">Quantity</th>
                            <th align="center">Price</th>
                            <th align="center">BUY</th>
                            <th align="center">Sub Total</th>
                        </tr>

                    <?php
                        error_reporting(0);
                        require_once("secure_connect.php");
                        $user = "root";
                        $pass = "root";
                        $result = "";
                        if($stmt = $mysqli -> prepare("SELECT * FROM item")) {
                            $stmt -> execute();
                            $stmt -> bind_result($id, $name, $description, $type, $qty, $price, $enabled);
                            $stack = array();
                            while ($stmt->fetch()) {
                                if($type == 0){ ?>
                                    <tr>
                                        <td align="center"> <?=$name; ?> </td>
                                        <td align="center"> <?=$description; ?> </td> 
                                        <td align="center"> <?=$qty; ?></td>
                                        <td align="center"> <?=$price; ?><input type="hidden" id="<?=$name;?>price" value=<?=$price;?>></td>
                                        <td align="center"><input type="text" name="<?=$id?>" id="<?=$name;?>qty" placeholder="Enter Amount"></td>
                                        <td id="<?=$name;?>subtotal">0.00</td>
                                        <?php  array_push($stack, $name); ?>
                                    </tr>

                            <?php }}} 
                        ?>
                    </table>
                </div>   

                <div class="innerDiv">
                        <h2>Craft Supplies</h2>
                        <table>
                            <tr>
                                <th align="center">Name</th>
                                <th align="center">Description</th>
                                <th align="center">Quantity</th>
                                <th align="center">Price</th>
                                <th align="center">BUY</th>
                                <th align="center">Sub Total</th>
                            </tr>
                             <?php
                        error_reporting(0);
                        require_once("secure_connect.php");
                        $user = "root";
                        $pass = "root";
                        $result = "";
                        if($stmt = $mysqli -> prepare("SELECT * FROM item")) {
                            $stmt -> execute();
                            $stmt -> bind_result($id, $name, $description, $type, $qty, $price, $enabled);
                            while ($stmt->fetch()) {
                                if($type == 1){ ?>
                                    <tr>
                                        <td align="center"> <?=$name; ?> </td>
                                        <td align="center"> <?=$description; ?> </td> 
                                        <td align="center"> <?=$qty; ?></td>
                                        <td align="center"> <?=$price; ?><input type="hidden" id="<?=$name;?>price" value=<?=$price;?>></td>
                                        <td align="center"><input type="text" name="<?=$id?>" id="<?=$name;?>qty" placeholder="Enter Amount"></td>
                                        <td id="<?=$name;?>subtotal">0.00</td>
                                        <?php  array_push($stack, $name); ?>
                                    </tr>

                            <?php }}} 
                        ?>
                        </table>
                </div>
            </div>
            <br />
            <h4><div id="tablefoot">Total:<span id="finaltotal">0.00</span></div></h4>
            <input type="submit" value="Submit form">
            <INPUT type="button" value="calculate" onClick="doTotals()" />
    </form>
    <script type="text/javascript">
        function doTotals() {
            var items = <?php echo json_encode($stack); ?>;
            var priceStr = 'price';
            var quantityStr = 'qty';
            var subtotalStr = 'subtotal';
            var total = 0;
            for (var i = 0; i < items.length; i++) {
                var price = document.getElementById(items[i] + priceStr).value;
                var quantity = document.getElementById(items[i] + quantityStr).value;
                document.getElementById(items[i] + subtotalStr)
                    .innerHTML = parseInt(price) * parseInt(quantity);
                total += price * quantity;
             }
            document.getElementById("finaltotal").innerHTML = total;
        }
    </script>
        </h2>

        <div>
            <p>
                <h2>Machine Services<h2>
            </p>
            <textarea rows="4" cols="93" name="description" form="orderForm">Write Description For Machine Services. Remember Cutting/Hammering for 1 min cost $5.00, Gluing/Sealing for 1 min cost $10.00, and Other specialty services for 1 min cost $10.00.
            </textarea>

        </div>

        <br>
</div>

<div class="content" id="page-2" style="width: 60%;">

    <h2>History</h2>   
</div>


<div class="content" id="page-3" style="width: 60%;">

    <h2>To Be Implemented</h2>
</div>

<div class = "content" id = "page-4" style="width: 60%;">
    
    <div class="innerDiv">
    <h2>Personal Information</h2>
        <table>
            <tr>
                <th align="center">Name</th>
                <th align="center">PeopleSoft</th>
                <th align="center">Group Number</th>
                <th align="center">Balance</th>
            </tr>
            <tr>
                <td align="center">David</td>
                <td align="center">1010101</td>
                <td align="center">1</td>
                <td align="center">$100</td>
            </tr>
               
        </table>
    </div>

    <div class="innerDiv">
    <h2>Group Information</h2>
        <table>
            <tr>
                <th align="center">Name</th>
                <th align="center">PeopleSoft</th>
                <th align="center">Group Number</th>
                <th align="center">Balance</th>
            </tr>
            <tr>
                <td align="center">David</td>
                <td align="center">1010101</td>
                <td align="center">1</td>
                <td align="center">$100</td>
            </tr>   
            <tr>
                <td align="center">Peter</td>
                <td align="center">1010110</td>
                <td align="center">1</td>
                <td align="center">$80</td>
            </tr>
            <tr>
                <td align="center">John</td>
                <td align="center">1010111</td>
                <td align="center">1</td>
                <td align="center">$50</td>
            </tr>
        </table>
    </div>


        <br>
        <p>
            <input type=button onClick="parent.location='changepass.php'" id="changePass" value='Change Password'>
        </p>
    </div>
</div>

<div class = "content" id = "page-5">
</div>



<script src="activatables.js" type="text/javascript"></script>
<script type="text/javascript">
activatables('page', ['page-0', 'page-1', 'page-2', 'page-3', 'page-4', 'page-5']);
</script>
</body>
</html>
