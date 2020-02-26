<?php
require_once 'db_config.php';

session_start();

$status = 0;

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    // set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
// if the get has been properly set
if (isset($_GET['type']) && isset($_GET['order']) && isset($_GET['genre'])) {
    //sort type
    $type = $_GET['type'];
    $order = $_GET['order'];
    $genre = $_GET['genre'];
                                    
    if ($order != 'ASC' && $order != 'DESC') {//MANUALLY SANITIZING ORDER STRING
        $order = 'ASC';
    }
                                    
    switch($type) { //MANUALLY SANITIZING TYPE STRING
        case "Title":
        case "Author":
        case "Price":
            break;
        default: //IF THE TYPE WASN'T ONE OF THOSE ^^
        $type = "Title";
    }
                                    
    //FILTERS
    if ($genre != 'Any') { //FILTER BY GENRE
        $genre = $_GET['genre'];
        $sql = $pdo->prepare("SELECT * FROM `Product` WHERE `ISBN-13` IN (SELECT `ISBN-13` FROM GenreList WHERE `GenreID`=(SELECT GenreID FROM Genre WHERE `GenreName`=?)) ORDER BY `$type` $order");
        $sql->bindValue(1,$genre);
        $sql->execute();
        $results = $sql->fetchAll();
    } else if (isset($_GET['search'])) { //FILTER BY SEARCH 
        $search =  $_GET['search'];
        $sql = $pdo->prepare("SELECT * FROM `Product` WHERE (`Title` LIKE CONCAT('%', ? '%') OR `Author` LIKE CONCAT('%', ? '%') OR `ISBN-13` LIKE CONCAT('%', ? '%')) ORDER BY `Title` ASC");
        $sql->bindValue(1,$search);
        $sql->bindValue(2,$search);
        $sql->bindValue(3,$search);
        $sql->execute();
        $results = $sql->fetchAll();
    } else {
        $sql = $pdo->prepare("SELECT * FROM Product ORDER BY `$type` $order");
        $sql->execute();
        $results = $sql->fetchAll();
    }
} else { // default to all books
    $sql = $pdo->prepare("SELECT * FROM Product");
    $sql->execute();
    $results = $sql->fetchAll();
}

include './scripts/php/favorite.php';

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
	<link rel="stylesheet" type="text/css" href="./css/catalog.css">

	<link rel="icon" type="image/png" href="./images/logo.png">
	<title>Catalog</title>
</head>

<body>
    
	<!-- NAV BAR -->
	<?php include './scripts/php/nav.php'; ?>
	<?php include './scripts/php/favoriteAlert.php'; ?>
	
	
	<div class="container-fluid" style="max-width: 1500px;">
        <div class="row">
            <div class="col-md-3">
                <?php include "./scripts/php/sidebar.php"?>
            </div>
            <div class="col-md-9">
                <div class="panel panel-success">           
                    <div class="panel-heading">
                        <h4>Search results</h4>
                    </div>
                        <!-- RESULTS -->
                        <?php
                        
                            foreach ($results as $key => $value) {
                                echo "<div class=\"result\">";
                                echo "  <div class=\"panel-body\">";
                                
                                echo "      <div class=\"row\">";
                                
                                echo "          <div class=\"col-sm-3\">";
                                echo "              <a href=\"./product.php?id=".$value['ISBN-13']."\"><img class=\"img img-responsive thumbnail\" src=\"./images/books/".$value['ImagePath']."\" alt=\"\"></a>";
                                echo "          </div>";
                                
                                echo "          <div class=\"col-sm-7\">";
                                echo "              <a href=\"./product.php?id=".$value['ISBN-13']."\" class=\"result-title\"><h2>".$value['Title']."</h2></a>";
                                echo "              <h3>"."By: ".$value['Author']."</h3>";
                                echo "              <h3>&curren; ".$value['Price']."</h3>";
                                if (strlen($value['Description']) > 200)
                                    echo "          <p>".substr($value['Description'], 0, 200)."<a href=\"./product.php?id=".$value['ISBN-13']."\"> [Read More...]</a>"."</p>";
                                else
                                    echo "          <p>".$value['Description']."</p>";
                                echo "          </div>";
                                
                                echo "          <div class=\"col-xs-2\">";
                                echo "              <form method=\"post\" action=\"./catalog.php?".$_SERVER["QUERY_STRING"]."\">";
                                echo "                  <button class=\"btn btn-warning\" name=\"favorite\" value=\"".$value['ISBN-13']."\"><i class=\"glyphicon glyphicon-heart\"></i> Favorite</button>";
                                echo "              </form>";
                                echo "          </div>";
                                
                                echo "      </div>"; 
                                echo "  </div>";
                                echo "</div>";
                                echo "<hr>";
                            }
                        
                        ?>
                        
                </div>
            </div>
        </div>
    </div>
	<!-- jQuery  -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<!-- Bootstrap - JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<!-- Other Scripts -->
	<script src="./scripts/javascript/alertDismisser.js"></script>
</body>


</html>
			