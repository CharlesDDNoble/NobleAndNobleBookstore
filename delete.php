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
	<title>Delete My Account</title>
</head>

<body>
    
    
	<div id="login-container" class="container">
	    
	    
    	<form id="login-form" method="post" action="./login.php">
    		<div class="form-group">
    			<h2>Are you sure you want to delete your account?</h2>
    		</div>
    		<div class="form-group">
    			<h3>Yes </h3><input type="radio" value="yes" name="delete">
    			<h3>No </h3><input type="radio" value="no" name="delete" checked>
    		</div>
    		<div class="form-group">
    			<button class="btn full-btn btn-success" type="submit">Confirm</button>
    		</div>
    	</form>
    
    </div>
	
	
</body>
</html>