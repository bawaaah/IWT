<?php
require_once "config.php"; //  connect to the database
session_start(); //  start session

if (isset($_POST["add"])) { //  is add button clicked or not
    if (isset($_SESSION["cart"])) { //  is session cart has any value with it
        $itemID = array_column($_SESSION["cart"], "id"); //get all 'id' coloumn values from session[cart] assoc into another array 
        if (!in_array($_GET["id"], $itemID)) { //  search is there any old id add button is submitted
            $count = count($_SESSION["cart"]); // count of the indxes of session[cart]
            $itemArray = array(
                //  set data to table
                'id' => $_GET["id"],
                'name' => $_POST["name"],
                'method' => $_POST["method"],
                'price' => $_POST["price"],
                'quantity' => $_POST["quantity"]
                
            );
            $sql = "INSERT into cart (itemID,sName,price,quantity,method) values ('{$itemArray['id']}','{$itemArray['name']}','{$itemArray['price']}','{$itemArray['quantity']}','{$itemArray['method']}')";
            $connection->query($sql);
            $_SESSION["cart"][$count] = $itemArray;
            echo '<script>alert("SERVICE ADDED TO CART")</script>';
            echo '<script>window.location="Laundry-Service-Page.php"</script>';
        } else {
            echo '<script>alert("SERVICE ALREADY ADD TO CART")</script>';
            echo '<script>window.location="Laundry-Service-Page.php"</script>';
        }
    } else {
        $itemArray = array(
            'id' => $_GET["id"],
            'name' => $_POST["name"],
            'method' => $_POST['method'],
            'price' => $_POST["price"],
            'quantity' => $_POST["quantity"]
            
        );
        $sql = "INSERT into cart (itemID,sName,price,quantity,method) values ('{$itemArray['id']}','{$itemArray['name']}','{$itemArray['price']}','{$itemArray['quantity']}','{$itemArray['method']}')";
        $connection->query($sql);
        $_SESSION["cart"][0] = $itemArray;
    }
}

if (isset($_GET["action"])) {
    if ($_GET["action"] == "delete") {
        foreach ($_SESSION["cart"] as $keys => $value) {
            if ($value["id"] == $_GET["id"]) {
                unset($_SESSION["cart"][$keys]);
                $key = $_GET["id"];
                $sql1 = "DELETE from cart where itemID = $key";
                $connection->query($sql1);
                echo '<script>alert("Product has been removed");</script>';
                echo '<script>window.location="Service-Cart.php";</script>';
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

    <title>Service</title>
    <link rel="stylesheet" href="s.css">
    <style>
        .method{
            color: white;
            background-color:  rgb(60, 60, 60);
            border: none;
            border-radius: 6px;
            padding: 4px;
            margin: 3px;
        
        
    }
        .container .row .add{
            font-weight: 650;
        }

        .row{
            display: flex;
            justify-content:space-evenly;
        }
        .container{
            padding: 60px;
            display: block;
            background-color: rgb(218, 218, 218);
    }
        </style>
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
                <li><a class="active" href="./Laundry-Service-Page.php">Service</a></li>
                <li><a href="#">Gallery</a></li>
                <li><a href="#">Feedback</a></li>
                <li><a href="Service-Cart.php">Cart</a></li>
            </ul>


        </nav>
    <div class="top-image">
        <p>See Our Services <br>
        <input type="button" value="Click Here" id="scroll"></p>
        
        <img src="top.jpg" alt="">
    </div>

    <div class="container">


        <?php

        $query = "SELECT * from item order by id asc";
        $result = $connection->query($query);

        if ($result->num_rows > 0) {
            echo "<div class='row'>";
            while ($row = $result->fetch_assoc()) {
                ?>

                
                    <form action="Laundry-Service-Page.php?action=add&id=<?php echo $row['id']; ?>" method="post">
                        <div class="item">
                            <img src="<?php echo $row['image']; ?>" alt="" srcset=""><br>
                            <label for="">
                                <?php echo $row['description']; ?>
                            </label><br>
                            <label for="">
                                <?php echo "$" . $row['price']; ?>
                            </label><br>
                            <input type="hidden" name="name" value="<?php echo $row['description']; ?>">
                            <input type="hidden" name="price" value="<?php echo $row['price']; ?>">
                            <input type="number" value="1" name="quantity" min=1 max=10><br>
                            <select name="method" class="method" required>
                                <option value="Select a method" selected disabled>Select a method</option>
                                <option value="Washing">Washing</option>
                                <option value="Pressing">Pressing</option>
                                <option value="Dry Clean">Dry Clean</option>
                            </select><br>
                            <input type="submit" value="ADD" class="add" name="add">
 
                        </div>
                    </form>
                    <?php
                            $temp = $row['id'] % 4;
                            if ($temp == 0) {
                                echo "</div>";
                                echo "<div class= 'row'>";
                            }
                            ?>
                
            <?php

            }
        }
        ?>
    </div>

    <script>
        var scrollButton = document.getElementById('scroll');

        function scrollToBottom() {
        window.scrollTo({
            top: 825,
            behavior: 'smooth'
        });
        }

        scrollButton.addEventListener('click', scrollToBottom);

    </script>

</body>

</html>



<?php $connection->close(); ?>