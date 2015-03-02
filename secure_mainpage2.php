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
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js">
window.onerror = function(msg, url, linenumber) {
    alert('Error message: '+msg+'\nURL: '+url+'\nLine Number: '+linenumber);
    return true;
};


// function doTotals() {
//     var items = <?php echo json_encode($stack); ?>;
//     var priceStr = 'price';
//     var quantityStr = 'qty';
//     var subtotalStr = 'subtotal';
//     var total = 0;
//     for (var i = 0; i < items.length; i++) {
//         var price = document.getElementById(items[i] + priceStr).value;
//         var quantity = document.getElementById(items[i] + quantityStr).value;
//         document.getElementById(items[i] + subtotalStr)
//             .innerHTML = parseInt(price) * parseInt(quantity);
//         total += price * quantity;
//     }
//     document.getElementById("finaltotal").innerHTML = total;
// }


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
</style>
</head>


<body>
<h1>My Homepage</h1>
<ol id="toc">
    <li><a href="#page-0"><span>LOGIN</span></a></li>
    <li><a href="#page-1"><span>HOME</span></a></li>
    <li><a href="#page-2"><span>BUY</span></a></li>
    <li><a href="#page-3"><span>INVENTORY</span></a></li>
    <li><a href="#page-4"><span>CART</span></a></li>
    <li><a href="#page-5"><span>ACCOUNT</span></a></li>
    

</ol>
<div class="content" id="page-0">
<form>
    <table align="center">
        <tr>
            <td>username:</td>
            <td><input type="text" name="username" value=""></td>
        </tr>
        <tr>
            <td>password:</td>
            <td><input type="password" name="password">&nbsp;&nbsp;<a href="url">Forgot your password?</a></td>
        </tr>       
        <tr>
            <td></td>
            <form>
                Login as:
                <input type="radio" name="identity" value="student">Student
                <input type="radio" name="identity" value="instructor">Instructor
                <input type="radio" name="identity" value="TA">TA
            </form>
        </tr>
        <tr align="center">
            <td colspan="2">
                <input type="checkbox" name="remember" value="remember">&nbsp;Remember me</br>
                <input type="submit" name="submit" value="Login">
            </td>
        </tr>
    </table>

</form>

</div>

<div class="content" id="page-1">
    <h2>Announcement</h2>
    <p><marquee behavior="scroll" direction="up" onmouseover="this.stop();" onmouseout="this.start();">
    <a href=" ">Click for detail!</a>
    </marquee></p>
</div>
<div class="content" id="page-2">
    <h2>Buy Supplies</h2>
    <form action="submitForm.aspp" id="orderForm">
        <hr>
            <div class="innerDiv">
                <h2>General Supplies</h2>
                <table>
                    <tr>
                        <td align="center">Name</td>
                        <td align="center">Description</td>
                        <td align="center">Quantity</td>
                        <td align="center">Price</td>
                        <td align="center">BUY</td>
                    </tr>

                <?php
                    error_reporting(0);
                    require_once("secure_connect.php");
                    $user = "root";
                    $pass = "root";
                    $result = "";
                    // $i = '1';
                    // echo $name = name;
                    
                    if($stmt = $mysqli -> prepare("SELECT * FROM item")) {
                        //$stmt -> bind_param("s", $item);

                        /* Execute it */
                        $stmt -> execute();

                          /* Bind results */
                        $stmt -> bind_result($id, $name, $description, $type, $qty, $price, $enabled);
                        $stack = array();
                          /* Fetch the value */
                        while ($stmt->fetch()) {
                            if($type == 0){ ?>
                                <tr>
                                    <td align="center"> <?=$name; ?> </td>
                                    <td align="center"> <?=$description; ?> </td> 
                                    <!-- <td align="center"> <?=$qty; ?><select id="sfc_qty" name="sfc_qty"> 
                                        <option>0</option>
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option></select>
                                    </td> -->
                                    <td align="center"> <?=$price; ?><input type="hidden" id="<?=$name;?>price" value=<?=$price;?>></td>
                                    <td align="center"><input type="text" name=<?=$name;?> id="<?=$name;?>qty" placeholder="Enter Amount"></td>
                                    <td id="<?=$name;?>subtotal"></td>
                                    <!-- <?php echo $name.'hello' ?> -->
                                    <?php 
                                    // $stack = array();
                                    array_push($stack, $name);
                                    // print_r($stack);

                                    ?>
                                    <!-- <?php $i++ ?> -->
                                </tr>

                        <?php }}} 
                    ?>
                    
                    <tr id="tablefoot"><td>Total:</td><td colspan="2" id="totalerr"><td id="finaltotal"></td></tr>
                </table>
            </div>    
            <div class="innerDiv">
                    <h2>Craft Supplies</h2>
                                    <table>
                        <tr>
                            <th>Item Name</th>
                            <th>Cost in dollars</th>
                            <th>Qty</th>
                        </tr>
                        <tr>
                            <td align="center">Pipe Cleaner</td>
                            <td align="center">$2.00</td>
                            <td><input type="text" name="pipeClean" placeholder="Enter Amount" ></td>
                        </tr>
                        <tr>
                            <td align="center">Construction Paper</td>
                            <td align="center">$2.00</td>
                            <td><input type="text" name="conPaper" placeholder="Enter Amount"></td>
                        </tr>
                        <tr>
                            <td align="center">Plastic Beads</td>
                            <td align="center">$20.00</td>
                            <td><input type="text" name="plasBead" placeholder="Enter Amount"></td>
                        </tr>
                    </table>
            </div>

</form>

<h2>
<br>

<INPUT type="button" value="calculate" onClick="doTotals()" />
<!-- <button type="button" onclick="doTotals()">Calculate total</button> -->

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

<button type="button">Add to Cart</button>
<button type="button">Clear All</button>
</h2>

<div>
<p>
    <h2>Machine Services<h2>
</p>
<textarea rows="4" cols="93" name="description" form="orderForm">Write Description For Machine Services. Remember Cutting/Hammering for 1 min cost $5.00, Gluing/Sealing for 1 min cost $10.00, and Other specialty services for 1 min cost $10.00.
</textarea>

</div>
<br>
<input type="submit" value="Submit form">
</div>


<div class="content" id="page-3">
    <h2>Stockroom Items</h2>
    <form action="submitForm.aspp" id="orderForm">
        <hr>
            <div class="innerDiv">
                <h2>General Supplies</h2>
                <table>
                    <tr>
                        <th>Name</th>
                        <th>Cost</th>
                        <th>Qty</th>
                    </tr>
                    <tr>
                        <td align="center">Styrofoam Cup</td>
                        <td align="center">$6.00</td>
                        <td><input type="text" name="styCup" placeholder="Enter Amount" ></td>
                    </tr>
                    <tr>
                        <td align="center">Paper Cup</td>
                        <td align="center">$1.00</td>
                        <td><input type="text" name="paperCup" placeholder="Enter Amount"></td>
                    </tr>
                    <tr>
                        <td align="center">Plastic Cup</td>
                        <td align="center">$5.00</td>
                        <td><input type="text" name="plasCup" placeholder="Enter Amount"></td>
                    </tr>
                </table>
            </div>    
            <div class="innerDiv">
                    <h2>Craft Supplies</h2>
                                    <table>
                        <tr>
                            <th>Name</th>
                            <th>Cost</th>
                            <th>Qty</th>
                        </tr>
                        <tr>
                            <td align="center">Pipe Cleaner</td>
                            <td align="center">$2.00</td>
                            <td><input type="text" name="pipeClean" placeholder="Enter Amount"></td>
                        </tr>
                        <tr>
                            <td align="center">Construction Paper</td>
                            <td align="center">$2.00</td>
                            <td><input type="text" name="conPaper" placeholder="Enter Amount"></td>
                        </tr>
                        <tr>
                            <td align="center">Plastic Beads</td>
                            <td align="center">$20.00</td>
                            <td align="center">10 /<button type="button">10</button></td>
                        </tr>
                    </table>
            </div>
</form>
</div>

<div class = "content" id = "page-4" style="width: auto;">
    <h2>Shopping Cart</h2>
    <table>
        <tr>
            <td align="center">Shopping Cart Items:</td>
            <td align="center">Cost:</td>
            <td align="center">Qty:</td>
        </tr>
        <tr>
            <td><a href=" ">Styrofoam Cup</a></br><button type="button">Delete</button></td>
            <td>$12.00</td>
            <td align="center"><select>
                            <option>0</option>
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                        </select></td>
        </tr>       
        <tr>
            <td><a href=" ">Pipe Cleaner</a></br><button type="button">Delete</button></td>
            <td>$4.00</td>
            <td align="center"><select>
                            <option>0</option>
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                        </select></td>
        </tr>
        <tr>
            <tr align="center">
                <td colspan="3">
                    Subtotal=$16.00
                </td>
            </tr>

        </tr>
        <tr align="center">
            <td colspan="3">
                <button type="button">Continue</button>
            </td>
        </tr>
    </table>
</div>

<div class = "content" id = "page-5">
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
            <h2>Status: 3/4 participant <td align="center"><select>
                            <option>open</option>
                            <option>closed</option>
                        </select></td>
        </p>
    </div>
    
</div>



<script src="activatables.js" type="text/javascript"></script>
<script type="text/javascript">
activatables('page', ['page-0', 'page-1', 'page-2', 'page-3', 'page-4', 'page-5']);
</script>
</body>
</html>

Displaying page2.html.