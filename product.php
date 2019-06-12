<?php
session_start();

$servername = 'mysql.hostinger.com';
$username = 'u905801586_admin';
$database = 'u905801586_noble';
$password = 'FinalProject1!';
$status = 0;

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    // set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if (isset($_GET['id'])) { //CHECK TO SEE IF THE GET IS SET
    
    $sql = $pdo->prepare("SELECT * FROM Product WHERE `ISBN-13`=?");
    $sql->bindValue(1,$_GET['id']);
    $sql->execute();
    $product = $sql->fetch();
    
    if ($product == false) { //PRODUCT DOESN'T EXIST
        //TO DO: MAKE ERROR PAGE TO REDIRECT TO FOR INVALID GET
        header("Location: ./index.php");
    } else if (isset($_POST['cart']) && isset($_SESSION['uid'])) { //CART REQUEST && LOGGED
        //CHECK TO SEE IF CART EXISTS
        $sql = $pdo->prepare("SELECT * FROM UserShoppingCart WHERE `UID`=? AND `ISBN-13`=?");
        $sql->bindValue(1,$_SESSION['uid']);
        $sql->bindValue(2,$_GET['id']);
        $sql->execute();
        $cart = $sql->fetch();
        
        $pdo->beginTransaction();
        
        if ($cart !== false) { //CART EXISTS, UPDATE IT
            $sql = $pdo->prepare("UPDATE UserShoppingCart SET `UnitsInCart`=? WHERE `USCID`=?");
            $sql->bindValue(1,$_POST['orderAmount']);
            $sql->bindValue(2,$cart['USCID']);
            $sql->execute();
            $pdo->commit();
            $status = 3;
        } else { //CREATE NEW CART
            $sql = $pdo->prepare("INSERT INTO UserShoppingCart (`ISBN-13`,`UID`,`UnitsInCart`) VALUES (?,?,?)");
            $sql->bindValue(1,$_GET['id']);
            $sql->bindValue(2,$_SESSION['uid']);
            $sql->bindValue(3,$_POST['orderAmount']);
            $sql->execute();
            $pdo->commit();
            $status = 4;
        }
    } else if (isset($_POST['cart']) && !isset($_SESSION['uid'])) { //CART SET && NOT LOGGED IN
        header("Location: ./login.php");  
    }
    
    include './scripts/php/favorite.php';
    
} else {
    //TO DO: MAKE ERROR PAGE TO REDIRECT TO FOR INVALID GET
    header("Location: ./index.php");
}

if (isset($_POST['rating'])) {
    //if the user isnt logged in redirect
    if (!isset($_SESSION['uid'])) 
    header("Location: ./login.php");
    
    $sql = $pdo->prepare("SELECT * FROM `ProductRating` WHERE `ISBN-13`=? AND UID=?");
    $sql->bindValue(1,$_GET['id']);
    $sql->bindValue(2,$_SESSION['uid']);
    $sql->execute();
    $rating = $sql->fetch();
    if ($rating != false) { //rating exists
        $pdo->beginTransaction();
        $sql = $pdo->prepare("UPDATE `ProductRating` SET `Rating`=? WHERE `ISBN-13`=? AND UID=?");
        $sql->bindValue(1,$_POST['rating']);
        $sql->bindValue(2,$_GET['id']);
        $sql->bindValue(3,$_SESSION['uid']);
        $sql->execute();
        $pdo->commit();
    } else {
        $pdo->beginTransaction();
        $sql = $pdo->prepare("INSERT INTO `ProductRating` (`Rating`,`ISBN-13`,`UID`) VALUES (?,?,?)");
        $sql->bindValue(1,$_POST['rating']);
        $sql->bindValue(2,$_GET['id']);
        $sql->bindValue(3,$_SESSION['uid']);
        $sql->execute();
        $pdo->commit();
    }
}

$sql = $pdo->prepare("SELECT AVG(`Rating`) as 'Average', COUNT(*) as 'TotalRatings' FROM `ProductRating` WHERE `ISBN-13`=?");
$sql->bindValue(1,$_GET['id']);
$sql->execute();
$rating = $sql->fetch();

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
	<link rel="stylesheet" type="text/css" href="./css/product.css">

	<link rel="icon" type="image/png" href="./images/logo.png">
	
	<title><?php echo $product['Title'];?></title>
</head>

<body>
	
	<?php include './scripts/php/nav.php'; ?>
    
    <?php include './scripts/php/favoriteAlert.php'; ?>

    <?php
    
        if ($status === 3) {
            echo "<div id=\"update-alert\" class=\"alert alert-success alert-dismissible fade in show\"" .
                 " style=\" width: 50%; margin: 0 auto 20px auto; text-align: center;\" role=\"alert\">";
            echo "Your cart has been updated!";
            echo "</div>";
        } else if ($status === 4) {
            echo "<div id=\"update-alert\" class=\"alert alert-success alert-dismissible fade in show\"" .
                 " style=\" width: 50%; margin: 0 auto 20px auto; text-align: center;\" role=\"alert\">";
            echo "The item has been added to your cart!";
            echo "</div>";
        } 
    
    ?>

	<main class="container">
		
		<div class="row">
            <div id="sidebar" class="col-xs-3">
                <?php include './scripts/php/sidebar.php'; ?>
            </div>
		    <div class="col-sm-9">
		        <div class="row">
		            
        			<div class="col-md-6">
        				<div id="image-container">
        					<?php 
        					    echo "<img class=\"img img-responsive\" id=\"product-image\" src=\"./images/books/".$product['ImagePath']."\" alt=\"\">";
        					?>
        				</div>
        			</div>
        			
        			<div class="col-md-6">
        				<div class="panel panel-success">
        					<div id="product-name" class="panel panel-heading">
        						<h3><?php echo $product['Title']; ?></h3>
        					</div>
        					<div id="product-price" class="panel panel-body">
        						<h3>By: <?php echo $product['Author']; ?></h3>
        					</div>
        					<div id="product-price" class="panel panel-body">
        						<h3>Price: &curren; <?php echo $product['Price']; ?></h3>
        					</div>
        					<div id="product-stock" class="panel panel-body">
        						<h3>In Stock: <?php echo $product['UnitsInStorage']; ?></h3>
        					</div>
        					<?php echo "<form method=\"post\" action=\"./product.php?id=".$product['ISBN-13']."\">"; ?> <!--SEND THE ID VIA GET && ORDER INFO VIA POST-->
                				<div id="product-stock" class="panel panel-body">
                                    <?php echo "<input type=\"number\" name=\"orderAmount\" value=\"1\" min=\"1\" max=\"".$product['UnitsInStorage']."\">"; ?> <button type="submit" value="submit" name="cart" style="margin-left: 5px;" class="btn btn-success">Add to Cart</button>
                                    <?php echo "<button class=\"btn btn-warning\" style=\"margin-left: 5px;\" name=\"favorite\" value=\"".$product['ISBN-13']."\"><i class=\"glyphicon glyphicon-heart\"></i> Favorite</button>"; ?>
                				</div>
            				</form>
            				<div id="product-review" class="panel panel-body">
            				    <?php 
            				        if ($rating['TotalRatings'] != 0)
        						        echo "<h3>Rating: ".number_format($rating['Average'], 2, '.', '')."/"."5 (".$rating['TotalRatings']." ratings) </h3>";
        						    else
        						        echo "<h3>Rating: No ratings!</h3>";
        						?>
        					</div>
        					<div id="product-rating" class="panel panel-body">
        					    <?php echo "<form method=\"post\" action=\"./product.php?id=".$product['ISBN-13']."\">"; ?>
        					    <?php 
        						    echo "<input type=\"number\" name=\"rating\" value=\"3\" min=\"1\" max=\"5\">";
        						    echo "<button class=\"btn btn-success\" style=\"margin-left: 5px;\" type=\"submit\">Rate it!</button>";
        						?>
        						</form>
        					</div>
        				</div>
        			</div>
        			
        		</div> <!--END OF ROW-->
        		
        		<div id="description-panel" class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <h3>Description</h3>
                            </div>
                            <div class="panel-body" id="description">
            					<h4><?php echo $product['Description']; ?></h4>
            				</div>
                        </div>
                    </div>
                </div> <!--END OF ROW-->
                
                <div id="details-panel" class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <h3>Details</h3>
                            </div>
                            <div class="panel-body" id="product-weight">
            					<h3>Weight: <?php echo $product['Weight']; ?> ounces</h3>
            				</div>
            				<div class="panel-body" id="product-dimensions">
            					<h3>Dimensions: <?php echo $product['Dimension']; ?></h3>
            				</div>
                        </div>
                    </div>
                </div> <!--END OF ROW-->
                
			</div>
			
		</div> <!--END OF ROW-->
		
	</main>
	
	<!-- jQuery  -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<!-- Bootstrap - JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<!-- Other Scripts -->
	<script src="./scripts/javascript/alertDismisser.js"></script>
</body>


</html>
			
