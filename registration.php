<?php
session_start();

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

//if all information was sent
if (isset($_POST['first']) && isset($_POST['last']) && isset($_POST['email']) && isset($_POST['pass1'])
    && isset($_POST['pass2']) && isset($_POST['city']) && isset($_POST['state']) && isset($_POST['zip'])
    && isset($_POST['phone'])) {
    
    //fetch the email provided
    $sql = $pdo->prepare('SELECT * FROM User WHERE Email=?');
    $sql->bindValue(1,$_POST['email']);
    $sql->execute();
    $user = $sql->fetch();
    
    //if the email already exists
    if ($user !== false) {
        $status = -2; // <--- Non-unique email
    } else { //try to insert the new user
        try {
            $pdo->beginTransaction();
            $sql = $pdo->prepare('INSERT INTO User 
            (Username, Password, Email, DateOfRegistration,FirstName, LastName, GiftCardBalance) 
            VALUES (?, ?, ?, ?, ?, ?, ?)');
            $sql->bindValue(1,$_POST['first'] . $_POST['last']);
            $sql->bindValue(2,password_hash($_POST['pass1'],PASSWORD_DEFAULT));
            $sql->bindValue(3,$_POST['email']);
            $sql->bindValue(4,date("Y-m-d H:i:s"));
            $sql->bindValue(5,$_POST['first']);
            $sql->bindValue(6,$_POST['last']);
            $sql->bindValue(7,500);
            
            $sql->execute();
            $pdo->commit();
            
            //get user data to set session
            $pdo->beginTransaction();
            $sql = $pdo->prepare('SELECT * FROM User WHERE Email=?');
            $sql->bindValue(1,$_POST['email']);
            $sql->execute();
            $user = $sql->fetch();
            
            //insert user details
            $sql = $pdo->prepare('INSERT INTO UserDetails 
            (UID, Address, City, State, Zip, Phone) 
            VALUES (?, ?, ?, ?, ?, ?)');
            $sql->bindValue(1,$user['UID']);
            $sql->bindValue(2,$_POST['address']);
            $sql->bindValue(3,$_POST['city']);
            $sql->bindValue(4,$_POST['state']);
            $sql->bindValue(5,$_POST['zip']);
            $sql->bindValue(6,$_POST['phone']);
            
            $sql->execute();
            $pdo->commit();
            
            $status = 1; //<--- ATTEMPT SUCCESS
        } catch (Exception $e) {
            // echo "<script>alert(\"An error has occurred: ". $e->getMessage() . "\");</script>";
            $pdo->rollBack();
            $status = -1; //<--- TRANSACTION ERROR
        }
    }
    
    if ($status === 1) {
        $_SESSION['uid'] = $user['UID'];
        $_SESSION['uname'] = $user['Username'];
        header('Location: ./index.php');
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<!-- Bootstrap -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	
	<!-- Stylesheets -->
    <link rel="stylesheet" href="./css/registration.css">

	<link rel="icon" type="image/png" href="./images/logo.png">
	<title>Registration</title>
	
</head>
<body>
    
    <?php
        if ($status === -1) {
            echo "<div id=\"update-alert\" class=\"alert alert-warning alert-dismissible fade in show\"" .
                 " style=\" width: 50%; margin: 0 auto 20px auto; text-align: center;\" role=\"alert\">";
            echo "An error occured on our end. Try again later.";
            echo "</div>";
        } else if ($status === -2) {
            echo "<div id=\"update-alert\" class=\"alert alert-warning alert-dismissible fade in show\"" .
                 " style=\" width: 50%; margin: 0 auto 20px auto; text-align: center;\" role=\"alert\">";
            echo "  The email provided already exists in our records";
            echo "</div>";   
        }
    ?>
    
    <main class="container-fluid">
    
    <form id="registration-form" method="post" action="./registration.php" onreset="resetForm()">
        <h1 style="text-align: center; margin-top: 5vh;">Registration</h1>
        
        
        
        <div class="row margin-top">
            <div class="col-sm-3">
                <h2>User Details</h2>
            </div>
            <div class="col-sm-9">
    
                <div class="row">
                    <div class="container-fluid">
                        <div class="col-sm-6">
                            <label for="first">First Name</label>
                            <input class="form-control" id="first" type="text" name="first" oninput="validate(0,1,null)">
                            </div>
                        <div class="col-sm-6">
                            <label for="last">Last Name</label>
                            <input class="form-control" id="last" type="text" name="last" oninput="validate(1,1,null)">
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="container-fluid">
                        <div class="col-sm-12">
                            <label for="email">Email</label>
                            <input class="form-control" id="email" type="text" name="email" placeholder="format for email is xxx@yyy.zzz" oninput="validate(2,7,null);">
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="container-fluid">
                        <div class="col-sm-6">
                            <label for="pass1">Password</label>
                            <input class="form-control" id="pass1" type="password" name="pass1" placeholder="between 6 and 12 characters" oninput="validate(3,6,null);">
                        </div>
                        <div class="col-sm-6">
                            <label for="pass2">Password Repeat</label>
                            <input class="form-control" id="pass2" type="password" name="pass2" placeholder="between 6 and 12 characters" oninput="validate(4,6,null);">
                        </div>
                    </div>
                </div>
                
           </div>
           
        </div> <!--END OF ROW-->
        
        <div class="row margin-top">
            <div class="col-sm-3">
                <h2>Shipping Information</h2>
            </div>
            <div class="col-sm-9">
                <div class="row">
                    <div class="container-fluid">
                        <div class="col-sm-12">
                            <label for="address">Address</label>
                            <input class="form-control" id="address" placeholder="138 Example blvd" type="text" name="address" onchange="validate(5,6,null)">
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="container-fluid">
                        <div class="col-sm-6">
                            <label for="city">City</label>
                            <input class="form-control" id="city" type="text" name="city" onchange="validate(6,3,null)">
                        </div>
                        <div class="col-sm-2">    
                            <label for="state">State</label>
                            <input class="form-control" id="state" type="text" name="state" placeholder="LL" onchange="validate(7,2,2)">
                        </div>
                        <div class="col-sm-4">    
                            <label for="zip">Zip</label>
                            <input class="form-control" id="zip" type="text" name="zip" placeholder="NNNNN" onchange="validate(8,5,5)">
                        </div>
                    </div>
                </div>
                
                
                <div class="row">
                    <div class="container-fluid">
                        <div class="col-sm-12">
                            <label for="phone">Phone</label>
                            <input class="form-control" id="phone" type="text" name="phone" placeholder="NNN-NNN-NNNN" oninput="validatePhone();">
                        </div>
                    </div>
                </div>
                
            </div>
        </div> <!--END OF ROW-->  
        
        
        <div id="confirmation" class="container-fluid">
            <!--<input id="agree" type="checkbox" name="agree">-->
            <button class="btn btn-success" type="reset" value="Reset">Reset Form</button>
            <button class="btn btn-success" id="submit" type="submit" name="Submit">Sign up!</button>
        </div>
    
    </form> <!-- END OF FORM -->
    
    
    </main>
    
    <!-- jQuery  -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<!-- Bootstrap - JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<!-- Other Scripts -->
    <script src="./scripts/javascript/validation.js"></script>
</body>
</html>
