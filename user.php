<?php
require_once 'db_config.php';

session_start();

if (!isset($_SESSION['uid'])) {
    header("Location: ./login.php?redirect=1");
}

$status = 0;

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    // set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

include './scripts/php/cartRemove.php';

if (isset($_POST['password'])) {
    if ($_POST['pass1'] !== $_POST['pass2']) {
        $status = -5;
    } else if (strlen($_POST['pass1']) < 6) {
        $status = -6;
    }  else {
        try {
            $pdo->beginTransaction();
            $sql = $pdo->prepare("UPDATE User SET Password=? WHERE `UID`=?");
            $sql->bindValue(1,password_hash($_POST['pass1'],PASSWORD_DEFAULT));
            $sql->bindValue(2,$_SESSION['uid']);
            $sql->execute();
            $pdo->commit();
            $status = 4;
        } catch (Exception $e) {
            $pdo->rollBack();
        }
    }
}

if (isset($_POST['delete'])) {
    header("Location: ./delete.php");
}

//GET USER INFO
$sql = $pdo->prepare("SELECT * FROM User WHERE `UID`=?");
$sql->bindValue(1,$_SESSION['uid']);
$sql->execute();
$user = $sql->fetch();

//GET USER DETAILS
$sql = $pdo->prepare("SELECT * FROM UserDetails WHERE `UID`=?");
$sql->bindValue(1,$_SESSION['uid']);
$sql->execute();
$details = $sql->fetch();

//GET CART INFO
$sql = $pdo->prepare("SELECT * FROM Product INNER JOIN (SELECT `ISBN-13`,`UnitsInCart` FROM UserShoppingCart WHERE `UID`=?) cart ON Product.`ISBN-13` = cart.`ISBN-13` ORDER BY Title ASC");
$sql->bindValue(1,$_SESSION['uid']);
$sql->execute();
$cart = $sql->fetchAll();

//GET PREVIOUS ORDERS
$sql = $pdo->prepare("SELECT `Title`,`UnitsPurchased`,`Date`,`ImagePath`,Product.`ISBN-13` FROM `Product` INNER JOIN (SELECT * FROM OrderInfo WHERE `UID`=?) Purchase ON Product.`ISBN-13` = Purchase.`ISBN-13` ORDER BY Date ASC");
$sql->bindValue(1,$_SESSION['uid']);
$sql->execute();
$purchases = $sql->fetchAll();

include './scripts/php/favorite.php';

//GET FAVORTIES
$sql = $pdo->prepare("SELECT Product.`ISBN-13`,`Title`,`ImagePath`,`Price`,`ProductFavoriteID` FROM Product RIGHT JOIN (SELECT * FROM ProductFavorite WHERE `UID`=?) Favorites ON Product.`ISBN-13`=Favorites.`ISBN-13` ORDER BY Title ASC");
$sql->bindValue(1,$_SESSION['uid']);
$sql->execute();
$favorites = $sql->fetchAll();

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
	<link type="text/css" href="./css/user.css"

	<link rel="icon" type="image/png" href="./images/logo.png">
	<title>My Account</title>
</head>

<body>
	
	<?php include './scripts/php/nav.php' ?>

    <?php include './scripts/php/favoriteAlert.php'; ?>

    <?php
        if ($status == -6) {
            echo "<div id=\"update-alert\" class=\"alert alert-danger alert-dismissible fade in show\"" .
                         " style=\" width: 50%; margin: 0 auto 20px auto; text-align: center;\" role=\"alert\">";
            echo "Password must be greater than 5 characters!";
            echo "</div>";
        } else if ($status == -5) {
            echo "<div id=\"update-alert\" class=\"alert alert-danger alert-dismissible fade in show\"" .
                 " style=\" width: 50%; margin: 0 auto 20px auto; text-align: center;\" role=\"alert\">";
            echo "Passwords must match!";
            echo "</div>";
        } else if ($status == 4) {
            echo "<div id=\"update-alert\" class=\"alert alert-success alert-dismissible fade in show\"" .
                 " style=\" width: 50%; margin: 0 auto 20px auto; text-align: center;\" role=\"alert\">";
            echo "Password Changed!";
            echo "</div>";
        }
    ?>

	<main class="container">
		
		<div class="row">
		
		    <div class="col-lg-7">
		    
    		    <div id="details" class="container-fluid">
        			<div class="panel panel-success">
        				<div class="panel-heading">
        					<h3>Account Details</h3>
        				</div>
        				
        				<?php
        				  if ($user != false) { //should always be the case
        				    echo "<div class=\"panel-body\">Username: ".$user['Username']."</div>";
        				    echo "<div class=\"panel-body\">Email: ".$user['Email']."</div>";
        				    echo "<div class=\"panel-body\">Account Since: ".date('F d, Y', strtotime($user['DateOfRegistration']))."</div>";
        				    echo "<div class=\"panel-body\">Name: ".$user['FirstName']." ".$user['LastName']."</div>";
        				    
        				    echo "<form class=\"form-inline\" method=\"post\" action=\"./user.php\">";
        				    echo "<div class=\"panel-body\">Change Password: </div>";
        				    echo "<div class=\"panel-body\">";
        				    echo "New Password: <input class=\"form-control\" name=\"pass1\" type=\"password\"> ";
        				    echo "Repeat: <input class=\"form-control\" name=\"pass2\" type=\"password\"> ";
        				    echo "<div class=\"panel-body\">";
        				    echo "</div>";
        				    echo "<button style=\"\" class=\"btn btn-default\" name=\"password\" type=\"submit\"><i class=\"glyphicon glyphicon-pencil\"></i> Change Password</button>";
        				    echo "</div>";
        				    echo "</form>";
        				    
        				    echo "<form method=\"post\" action=\"./user.php\">";
        				    echo "<div class=\"panel-body\"><button class=\"btn btn-danger\" name=\"delete\" type=\"submit\"><i class=\"glyphicon glyphicon-remove-circle\"></i> Delete Account</button></div>";
        				    echo "</form>";
        				  } else {
                            echo "<div class=\"panel-body\">AN ERROR OCCURED</div>";
        				  }
        				  
        				  
        				?>
        			</div>
        		</div> <!-- END OF DETAILS -->
		
		    </div>
		
		    <div class="col-lg-5">
		
    		    <div id="cart" class="container-fluid">
        			<div class="panel panel-success">
        				<div class="panel-heading">
        					<h2>Cart</h2>
        				</div>
        				<?php
        				    if ($cart == false) {
                                echo "<div class=\"panel-body result\">Your cart is empty!</div>";
                            } else {
                                $count = 0;
        				        foreach ($cart as $key => $value) {
        				            $count++;
        				            if ($count > 2) break;
                                    echo "<div class=\"panel-body result\">";
                                    
                                    echo "  <div class=\"row\">";
                                    
                                    echo "      <div class=\"col-sm-4\">";
                                    echo "          <a href=\"./product.php?id=".$value['ISBN-13']."\"><img class=\"img img-responsive thumbnail\" src=\"./images/books/".$value['ImagePath']."\" alt=\"\"></a>";
                                    echo "      </div>"; 
                                    
                                    echo "      <div class=\"col-sm-4\">";
                                    echo "          <a href=\"./product.php?id=".$value['ISBN-13']."\" class=\"result-title\"><h4>".$value['Title']."</h4></a>";
                                    echo "          <h3>&curren; ".$value['Price']."</h3>";
                                    echo "          <h4>In cart: ".$value['UnitsInCart']."</h4>";
                                    echo "      </div>";
                                    
                                    echo "      <div class=\"col-sm-4\">";
                                    echo "          <form method=\"post\" action=\"./user.php\">";
                                    echo "          <input name=\"remove\" value=\"".$value['ISBN-13']."\" hidden>";
                                    echo "          <button class=\"btn btn-danger\" type=\"submit\"><i class=\"glyphicon glyphicon-remove-sign\"></i> Remove</button>";
                                    echo "          </form>";
                                    echo "      </div>";
                                    
                                    echo "  </div>";
                                    
                                    echo "</div>";
                                    echo "<hr>";
                                    
                                }
                                if ($count > 2)
                                    echo "<div class=\"panel-body result\" style=\"text-align: center;\"><a href=\"./checkout.php\"><h3>[Full Cart...]</h3></a></div>";
                            }
                            
                            
                            ?>
        			</div>
        		</div> <!-- END OF CART -->
		
		    </div>
		    
        </div>
		    
        <div class="row">
		    
		    <div class="col-md-7">
		
        		<div id="purchases" class="container-fluid">
        			<div class="panel panel-success">
        				<div class="panel-heading">
        					<h2>Purchase History</h2>
        				</div>
        				<?php
        				    if ($purchases == false) {
                                echo "<div class=\"panel-body result\">No previous orders!</div>";
                            } else {
        				        foreach ($purchases as $key => $value) {
                                    echo "<div class=\"panel-body result\">";
                                    
                                    echo "  <div class=\"row\">";
                                    
                                    echo "      <div class=\"col-sm-4\">";
                                    echo "          <a href=\"./product.php?id=".$value['ISBN-13']."\"><img class=\"img img-responsive
                                                    thumbnail\" src=\"./images/books/".$value['ImagePath']."\" alt=\"\"></a>";
                                    echo "      </div>"; 
                                    
                                    echo "      <div class=\"col-sm-4\">";
                                    echo "          <a href=\"./product.php?id=".$value['ISBN-13']."\" class=\"result-title\"><h3>".$value['Title']."</h3></a>";
                                    echo "          <h4>Units purchased: ".$value['UnitsPurchased']."</h4>";
                                    echo "      </div>";
                                    
                                    echo "      <div class=\"col-sm-4\">";
                                    echo "          <h3>".date('F d, Y', strtotime($value['Date']))."</h3>";
                                    echo "      </div>";
                                    
                                    echo "  </div>";
                                    
                                    echo "</div>";
                                    echo "<hr>";
                                }
                            }
                            
                            
                            ?>
        			</div>
        		</div> <!-- END OF PURCHASES -->
    		
    		</div>
    		
    		<div class="col-md-5">
    		
        		<div id="favorites" class="container-fluid">
        			<div class="panel panel-success">
        				<div class="panel-heading">
        					<h2>Favorites</h2>
        				</div>
        				<?php
        				    if ($favorites == false) {
                                echo "<div class=\"panel-body result\">No items Favorited!</div";
                            } else {
        				        foreach ($favorites as $key => $value) {
                                    echo "<div class=\"panel-body result\">";
                                    
                                    echo "  <div class=\"row\">";
                                    
                                    echo "      <div class=\"col-sm-4\">";
                                    echo "          <a href=\"./product.php?id=".$value['ISBN-13']."\"><img class=\"img img-responsive
                                                    thumbnail\" src=\"./images/books/".$value['ImagePath']."\" alt=\"\"></a>";
                                    echo "      </div>"; 
                                    
                                    echo "      <div class=\"col-sm-4\">";
                                    echo "          <a href=\"./product.php?id=".$value['ISBN-13']."\" class=\"result-title\"><h3>".$value['Title']."</h3></a>";
                                    echo "          <h3>&curren; ".$value['Price']."</h3>";
                                    echo "      </div>";
                                    
                                    echo "      <div class=\"col-sm-4\">";
                                    echo "          <form method=\"post\" action=\"./user.php\">";
                                    echo "              <button class=\"btn btn-warning\" name=\"favorite\" value=\"".$value['ISBN-13']."\"><i class=\"glyphicon glyphicon-heart\"></i> Favorite</button>";
                                    echo "          </form>";
                                    echo "      </div>";
                                    
                                    echo "  </div>";
                                    
                                    echo "</div>";
                                    echo "<hr>";
                                }
                            }
                        ?>
        			</div>
        
        		</div> <!-- END OF FAVORITES -->
		
		    </div>
		
		</div>

	</main> <!-- END OF MAIN DIV -->
	<!-- jQuery  -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<!-- Bootstrap - JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<!-- Other Scripts -->
	<script src="./scripts/javascript/alertDismisser.js"></script>
</body>


</html>
			