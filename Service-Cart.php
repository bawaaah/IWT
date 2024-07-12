<?php include "config.php";

    session_start();

    if(isset($_GET["action"])){
        if($_GET["action"] == "update"){
            foreach ($_SESSION["cart"] as $keys => $value){
                if ($value["id"] == $_GET["id"]){
                    $key = $_GET["id"];
                    $q = $value["quantity"];
                    $qq = $_POST["qnt"];
                    $sql2 = "UPDATE cart SET quantity = $qq where itemID = $key";
    
                    $connection->query($sql2);
                    //echo '<script>window.location="Service-Cart.php";</script>';
                }
            }
        }
    }

    
                                                                                                               
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="./style.css">

    <title>CART</title>
    <link rel="stylesheet" href="./cart.css">



</head>
<body>
    <nav>
                <div class="logo">DIRT BUSTERS</div>
                <input type="checkbox" id="click">
                <label for="click" class="menu-btn">
                    <i class="fa fa-bars"></i>
                </label>
                <ul> 
                    <li><a href="#">Home</a></li>
                    <li><a href="#">About</a></li> 
                    <li><a href="./Laundry-Service-Page.php">Service</a></li>
                    <li><a href="#">Gallery</a></li>
                    <li><a href="#">Feedback</a></li>
                    <li><a class="active" href="Service-cart.php">Cart</a></li>
                </ul>


            </nav>
            <h2>CART</h2>
    <div class="container">
        <div class="cart">
                    <div class="tab">
                        <table border="1px">
                            <th>Service Desciption</th>
                            <th>Method</th>
                            <th>Quantity</th>
                            <th>Unit Price<br>(USD)</th>
                            <th>Total price<br>(USD)</th>
                            <th>Edit</th>
                            <th>REMOVE</th>
                            <?php

                            $sql = "SELECT itemID,sName,price,quantity,method FROM cart";

                            $result = $connection->query($sql);

                            if($result->num_rows>0){
                                while($row = $result->fetch_assoc()){

                                    ?>
                                    <form action="Service-Cart.php?action=update&id=<?php echo $row['itemID'];?>" method="post">
                                    
                                        <tr>
                                            <td><?php echo $row["sName"];?></td>
                                            <td><?php echo $row["method"];?></td>
                                            <td>  
                                                <input type="number" name="qnt" id="<?php echo $row['itemID']; ?>" value="<?php echo $row["quantity"];?>" max="10" min="1">
                                            </td>
                                            
                                            <td id="price"><?php echo $row["price"];?></td>
                                            <td id="value"><?php echo ($row["quantity"] * $row["price"]);?></td>
                                            
                                            <td><input type="submit" value="UDPATE" class="update"></td>
                                            <td><a href="Laundry-Service-Page.php?action=delete&id=<?php echo $row['itemID']; ?>" class="delete"><span>Remove Item</span></a></td>
                                        </tr>
                                    
                                            
                                    </form>
                                    <?php
                                        $total = $total + ($row["quantity"] * $row["price"]);
                                
                                

                                }
                            }
                            ?>




                        </table>
                    </div>
                </div>

                <div class="total">
                    <p>Total</p>
                    <label for=""><?php echo "USD " . number_format($total,2);?></label><br>
                    <input type="button" value="Checkout">
                </div>

    </div>

    
</body>
</html>


<?php $connection->close(); ?>