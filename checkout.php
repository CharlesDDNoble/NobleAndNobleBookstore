<?php
session_start();

if (!isset($_SESSION['uid'])) {
    header("Location: ./login.php?redirect=1");
}

$servername = 'mysql.hostinger.com';
$username = 'u905801586_admin';
$database = 'u905801586_noble';
$password = 'FinalProject1!';
$status = 0; //<--- transaction status

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    // set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

include './scripts/php/cartRemove.php';

if (isset($_POST['submit'])) { //PLACE ORDER
    //GET CART INFO
    $sql = $pdo->prepare("SELECT Product.`ISBN-13`,`Title`,`Price`,`ImagePath`,`UnitsInCart`,`UnitsInStorage` FROM Product RIGHT JOIN (SELECT `ISBN-13`,`UnitsInCart` FROM UserShoppingCart WHERE `UID`=?) cart ON Product.`ISBN-13` = cart.`ISBN-13`");
    $sql->bindValue(1,$_SESSION['uid']);
    $sql->execute();
    $cart = $sql->fetchAll();
    
    //GET USER INFORMATION
    $sql = $pdo->prepare("SELECT * FROM User WHERE `UID`=?");
    $sql->bindValue(1,$_SESSION['uid']);
    $sql->execute();
    $user = $sql->fetch();
    $wallet = $user['GiftCardBalance'];
    
    $pdo->beginTransaction();
    try {
        if ($cart != false) {
            foreach($cart as $key => $value) {
                $orderCost = $value['Price'] * $value['UnitsInCart'];
                //if this order cost is greater than the user wallet
                if ($orderCost > $wallet) {
                    $status = -2;
                    throw new Exception("InvalidFunds");
                } else if ($value['UnitsInCart'] > $value['UnitsInStorage']) { //request greater than total
                    $status = -3;
                    throw new Exception("InvalidUnits");
                } else { //Order is valid, try to perform transaction
                    //update wallet
                    $wallet -= $orderCost;
                    $sql = $pdo->prepare("UPDATE User SET `GiftCardBalance`=? WHERE `UID`=?");
                    $sql->bindValue(1,$wallet);
                    $sql->bindValue(2,$_SESSION['uid']);
                    $sql->execute();
                    
                    //update units
                    $sql = $pdo->prepare("UPDATE Product SET `UnitsInStorage`=? WHERE `ISBN-13`=?");
                    $sql->bindValue(1,$value['UnitsInStorage'] - $value['UnitsInCart']);
                    $sql->bindValue(2,$value['ISBN-13']);
                    $sql->execute();
                    
                    //delete item from cart
                    $sql = $pdo->prepare("DELETE FROM UserShoppingCart WHERE (`ISBN-13`=? AND `UID`=?)");
                    $sql->bindValue(1,$value['ISBN-13']);
                    $sql->bindValue(2,$_SESSION['uid']);
                    $sql->execute();
                    
                    //add order
                    $sql = $pdo->prepare("INSERT INTO OrderInfo (UID, `ISBN-13`, UnitsPurchased, TotalPrice, Date) VALUES (?,?,?,?,?)");
                    $sql->bindValue(1,$_SESSION['uid']);
                    $sql->bindValue(2,$value['ISBN-13']);
                    $sql->bindValue(3,$value['UnitsInCart']);
                    $sql->bindValue(4,$orderCost);
                    $sql->bindValue(5,date("Y-m-d H:i:s"));
                    $sql->execute();
                }
            }
            
            //if all transactions were successful, commit
            $pdo->commit();
            $status = 1; //ORDER SUCCESSFUL
        } else { //EMPTY CART
            $status = -1;
            throw new Exception("EmptyCart");
        }
    } catch (Exception $e) { //rollback on any error
        if (!isset($status)) $status = -4;
        $pdo->rollBack();
    }
}

//GET USER DETAILS
$sql = $pdo->prepare("SELECT * FROM UserDetails WHERE `UID`=?");
$sql->bindValue(1,$_SESSION['uid']);
$sql->execute();
$details = $sql->fetch();

//GET CART INFO
$sql = $pdo->prepare("SELECT Product.`ISBN-13`,`Title`,`Price`,`ImagePath`,`UnitsInCart` FROM Product RIGHT JOIN (SELECT `ISBN-13`,`UnitsInCart` FROM UserShoppingCart WHERE `UID`=?) cart ON Product.`ISBN-13` = cart.`ISBN-13` ORDER BY Title ASC");
$sql->bindValue(1,$_SESSION['uid']);
$sql->execute();
$cart = $sql->fetchAll();

//GET NEW ORDER INFO
$sql = $pdo->prepare("SELECT SUM(cart.`UnitsInCart`) as 'TotalUnits', SUM(Price * UnitsInCart) as 'TotalPrice' FROM (SELECT Product.`ISBN-13`,`Title`,`Price`,`ImagePath`,`UnitsInCart` FROM Product RIGHT JOIN (SELECT `ISBN-13`,`UnitsInCart` FROM UserShoppingCart WHERE `UID`=?) cart ON Product.`ISBN-13` = cart.`ISBN-13`) cart");
$sql->bindValue(1,$_SESSION['uid']);
$sql->execute();
$order = $sql->fetch();

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Bootstrap -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<!-- Stylesheets -->
	<link rel="stylesheet" type="text/css" href="./css/nav.css">
	<link rel="stylesheet" type="text/css" href="./css/checkout.css">

	<link rel="icon" type="image/png" href="./images/logo.png">
	<title>Checkout</title>
</head>

<body>
	
	<?php include './scripts/php/nav.php' ?>
    
    <?php 
        if ($status == 1) {
            echo "<div id=\"update-alert\" class=\"alert alert-success alert-dismissible fade in show\"" .
                 " style=\" width: 50%; margin: 0 auto 20px auto; text-align: center;\" role=\"alert\">";
            echo "Your order has been successfully placed!";
            echo "</div>";
        } else if ($status == -1) {
            echo "<div id=\"update-alert\" class=\"alert alert-warning alert-dismissible fade in show\"" .
                 " style=\" width: 50%; margin: 0 auto 20px auto; text-align: center;\" role=\"alert\">";
            echo "  Your cart is empty!";
            echo "</div>";
        } else if ($status == -2) {
            echo "<div id=\"update-alert\" class=\"alert alert-danger alert-dismissible fade in show\"" .
                 " style=\" width: 50%; margin: 0 auto 20px auto; text-align: center;\" role=\"alert\">";
            echo "  Insufficent funds!";
            echo "</div>";
        } else if ($status == -3) {
            echo "<div id=\"update-alert\" class=\"alert alert-danger alert-dismissible fade in show\"" .
                 " style=\" width: 50%; margin: 0 auto 20px auto; text-align: center;\" role=\"alert\">";
            echo " The number of units requested is greater than the number of units in storage!";
            echo "</div>";
        } else if ($status == -4) {
            echo "<div id=\"update-alert\" class=\"alert alert-danger alert-dismissible fade in show\"" .
                 " style=\" width: 50%; margin: 0 auto 20px auto; text-align: center;\" role=\"alert\">";
            echo " There was an error processing your order. Please try again later.";
            echo "</div>";
        }
    ?>
    
    <div class="container">
    
        <h1>Review your order</h1>
    
        <div class="row">
        
            <div class="col-md-6">
                <form method="post" action="./checkout.php">
        	        <div class="panel panel-warning">
        	            <div class="panel-heading"><h3>Order Summary</h3></div>
        	            <div class="panel-body">
        	                <div class="col-xs-6">Total Items: </div>
        	                <div class="col-xs-6"><?php 
        	                if (isset($order['TotalUnits']))
        	                    echo $order['TotalUnits'];
        	                else
        	                    echo "0";
        	                    
        	                ?></div>
        	            </div>
        	            <div class="panel-body">
        	                <div class="col-xs-6">Total Price: </div>
        	                <div class="col-xs-6"><?php 
        	                    if (isset($order['TotalPrice']))
        	                        echo "&curren; ".$order['TotalPrice'];
        	                    else
        	                        echo "0";
        	                ?></div>
        	            </div>
        	            <div class="panel-body" style="text-align: center;">
        	                <button class="btn btn-warning"  type="submit" name="submit" value="true" style="width: 50%; margin-top: 0px;">Place Order</button>
        	            </div>
        	        </div>
    	        </form>
    	    </div> <!-- END OF ORDER DETAILS-->
        
            <div class="col-md-6">
                <!--SHIPPING ADDRESS-->
                <div class="panel panel-success">
                    <div class="panel-heading"><h3>Shipping Information</h3></div>
                    <div class="panel-body">
        	           <div class="col-xs-6">Address: </div>
        	           <div class="col-xs-6"><?php echo $details['Address'];?></div>
        	        </div>
        	        <div class="panel-body">
        	           <div class="col-xs-6">City: </div>
        	           <div class="col-xs-6"><?php echo $details['City']. ", ".$details['State'];?></div>
        	        </div>
        	        <div class="panel-body">
        	           <div class="col-xs-6">Zip: </div>
        	           <div class="col-xs-6"><?php echo $details['Zip'];?></div>
        	        </div>
        	        <div class="panel-body">
        	           <div class="col-xs-6">Phone number:</div>
        	           <div class="col-xs-6"><?php echo $details['Phone'];?></div>
        	        </div>
                </div>
            </div> <!-- END OF SHIPPING DETAILS-->
            
        </div>
                
                
        <div class="row">
            <div id="cart" class="col-md-6">
                <div class="panel panel-success">
                	<div class="panel-heading"><h3>Cart</h3></div>
                		<?php
                            
                            foreach ($cart as $key => $value) {
                                    echo "<div class=\"panel-body result\">";
                                    
                                    echo "  <div class=\"row\">";
                                    
                                    echo "      <div class=\"col-sm-4\">";
                                    echo "          <a href=\"./product.php?id=".$value['ISBN-13']."\"><img class=\"img img-responsive thumbnail\" src=\"./images/books/".$value['ImagePath']."\" alt=\"\"></a>";
                                    echo "      </div>"; 
                                    
                                    echo "      <div class=\"col-sm-5\">";
                                    echo "          <a href=\"./product.php?id=".$value['ISBN-13']."\" class=\"result-title\"><h3>".$value['Title']."</h3></a>";
                                    echo "          <h3>&curren; ".$value['Price']."</h3>";
                                    echo "          <h3>In cart: ".$value['UnitsInCart']."</h3>";
                                    echo "      </div>";
                                    
                                    echo "      <div class=\"col-sm-3\">";
                                    echo "          <form method=\"post\" action=\"./checkout.php\">";
                                    echo "          <input name=\"remove\" value=\"".$value['ISBN-13']."\" hidden>";
                                    echo "          <button class=\"btn btn-danger\" type=\"submit\"><i class=\"glyphicon glyphicon-remove-sign\"></i> Remove</button>";
                                    echo "          </form>";
                                    echo "      </div>";
                                    
                                    echo "  </div>";
                                    
                                    echo "</div>";
                                    echo "<hr>";
                            }
                            
                            if ($cart == false) {
                                echo "<div class=\"panel-body result\">Your cart is empty!</div";
                            }
                            
                            ?>
                </div>
            </div>
        </div> <!-- END OF CART -->
	
	</div>
	
	<!-- jQuery  -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<!-- Bootstrap - JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<!-- Other Scripts -->
	<script src="./scripts/javascript/alertDismisser.js"></script>
</body>


</html>
			