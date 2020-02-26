<?php
require_once 'db_config.php';

session_start();

$status = 0; //<---- No Attempt

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    // set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if (isset($_POST['delete'])) {
    if ($_POST['delete'] == 'yes') {
        try {
            $pdo->beginTransaction();
            
            //delete account
            $sql = $pdo->prepare('DELETE FROM User WHERE UID=?');
            $sql->bindValue(1, $_SESSION['uid']);
            $sql->execute();
            
            //delete shipping
            $sql = $pdo->prepare('DELETE FROM UserDetails WHERE UID=?');
            $sql->bindValue(1, $_SESSION['uid']);
            $sql->execute();
            
            //delete cart
            $sql = $pdo->prepare('DELETE FROM UserShoppingCart WHERE UID=?');
            $sql->bindValue(1, $_SESSION['uid']);
            $sql->execute();
            
            //delete favorites
            $sql = $pdo->prepare('DELETE FROM ProductFavorite WHERE UID=?');
            $sql->bindValue(1, $_SESSION['uid']);
            $sql->execute();
            
            //delete orders
            $sql = $pdo->prepare('DELETE FROM OrderInfo WHERE UID=?');
            $sql->bindValue(1, $_SESSION['uid']);
            $sql->execute();
            
            $pdo->commit();
            $_SESSION = null;
            session_destroy();
            $status = 2;
        } catch (Exception $e) {
            $pdo->rollBack();
        }
    } else {
        header('Location: ./user.php');
    }
} else if (isset($_GET['logout'])) {
    $_SESSION = null;
    session_destroy();
    $status = 1; // <-- LOGOUT SUCCESSFUL
} else if (isset($_POST['email']) && isset($_POST['password'])) {
    $sql = $pdo->prepare('SELECT * FROM User WHERE Email=?');
    $sql->bindValue(1, $_POST['email']);
    $sql->execute();
    
    $user = $sql->fetch();
    if ($user == false) { 
        $status = -2; // RECORD DOESN'T EXIST
    } else if (password_verify($_POST['password'], $user['Password'])) {
        $_SESSION['uid'] = $user['UID'];
        $_SESSION['uname'] = $user['Username'];
        header('Location: ./index.php');
    } else {
        $status = -1; //<--- ATTEMPT FAILED
    }

}

?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Bootstrap -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<!-- jQuery  -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<!-- Other Scripts -->
	<!-- Stylesheets -->
	<link rel="stylesheet" type="text/css" href="./css/login.css">

	<link rel="icon" type="image/png" href="./images/logo.png">
	<title>Sign in</title>
</head>

<body>
    
    
	<div id="login-container" class="container">
	    
	    <?php
    
        if ($status === 1) {
            echo "<div id=\"update-alert\" class=\"alert alert-success alert-dismissible fade in show\"" .
                 " role=\"alert\">";
            echo "You have been successfully logged out!";
            echo "</div>";
        } else if (isset($_GET['redirect'])) {
            echo "<div id=\"update-alert\" class=\"alert alert-danger alert-dismissible fade in show\"" .
                 " role=\"alert\">";
            echo "Please login to access that page!";
            echo "</div>";
        } else if ($status === -1) {
            echo "<div id=\"update-alert\" class=\"alert alert-warning alert-dismissible fade in show\"" .
                 " role=\"alert\">";
            echo "  The information provided <strong>did not</strong> match our records.";
            echo "</div>";
        } else if ($status === -2) {
            echo "<div id=\"update-alert\" class=\"alert alert-warning alert-dismissible fade in show\"" .
                 " role=\"alert\">";
            echo "  The information provided <strong>does not</strong> exist in our records.";
            echo "</div>";
        } else if ($status === 2) {
            echo "<div id=\"update-alert\" class=\"alert alert-success alert-dismissible fade in show\"" .
                 " role=\"alert\">";
            echo "Your account has been successfully deleted!";
            echo "</div>";
        }
    
        ?>
	    
    	<form id="login-form" method="post" action="./login.php">
    		<div class="form-group">
    			<h1>Sign in</h1>
    		</div>
    		<div class="form-group">
    			<label for="email">Email</label>
    			<input type="text" class="form-control" name="email" placeholder="Enter email">
    		</div>
    		<div class="form-group">
    			<label for="password">Password</label>
    			<input type="password" class="form-control" name="password" placeholder="Password">
    		</div>
    		<div class="form-group">
    			<button class="btn full-btn btn-success" type="submit">Submit</button>
    		</div>
    	</form>
    
    	<div id="register-group">
    		<div class="form-group" style="text-align: center;">
    			<h4>Don't have an Account?</h4>
    		</div>
    		<div class="form-group">
    			<button onclick="register()" type="button" class="btn full-btn" style="background-color: #424242;">Register</button>
    		</div>
    	</div>
    </div>
	
	<script>
	    function register() {
	        location.href = "registration.php";
	    }
	</script>
	<script src="./scripts/javascript/alertDismisser.js"></script>
</body>
</html>