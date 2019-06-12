<?php
    if (!isset($pdo)) {
        $servername = 'mysql.hostinger.com';
        $username = 'u905801586_admin';
        $database = 'u905801586_noble';
        $password = 'FinalProject1!';
        
        try {
            $pdo = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
            // set the PDO error mode to exception
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }
	echo "<script>function sendForm() {document.getElementById(\"nav-form\").submit()}</script>";
	$sql = $pdo->prepare("SELECT * From User WHERE UID=?");
	$sql->bindValue(1,$_SESSION['uid']);
	$sql->execute();
	$balance = $sql->fetch()['GiftCardBalance'];
?>

<nav class="navbar navbar-default">
	<div class="container-fluid">
		<div class="navbar-header">
			<a class="navbar-brand" href="./index.php">Noble &amp; Noble</a>
		</div>
		<ul id="nav-list" class="nav navbar-nav">
			<li style="padding: 7px 8px 6px 8px">
				<form id="nav-form" method="get" action="catalog.php" class="form-inline">
					<div class="form-group">
					    <input type="text" name="type" value="Title" hidden> <!-- SORT TYPE -->
					    <input type="text" name="order" value="ASC" hidden> <!-- ORDER -->
					    <input type="text" name="genre" value="Any" hidden> <!-- GENRE -->
						<label class="sr-only" for="search">Search</label>
						<div class="input-group">
							<input type="text" name="search" class="form-control" id="search-bar" placeholder="Enter Book Title">
							<div onclick="sendForm()" id="search-btn" class="input-group-addon"><i class="glyphicon glyphicon-search"></i></div>
						</div>
					</div>
				</form>
			</li>
			<li><a href="./catalog.php?type=Title&order=ASC&genre=Any"><i class="glyphicon glyphicon-book"></i> All Books</a></li>
			
			<?php
			    if (isset($_SESSION['uid'])) {
			        echo "<li><a href=\"#\">&curren; $balance</a></li>";
    			    echo "<li><a href=\"./user.php\"><i class=\"glyphicon glyphicon-user\"></i> My Account</a></li>";
    			    echo "<li><a href=\"./checkout.php\"><i class=\"glyphicon glyphicon-shopping-cart\"></i> Checkout</a></li>";
    			    echo "<li><a href=\"./login.php?logout=1\"><i class=\"glyphicon glyphicon-log-out\"></i> Logout</a></li>";
			    } else {
			        echo "<li><a href=\"./login.php\"><i class=\"glyphicon glyphicon-log-in\"></i> Login</a></li>";
			    }
		    ?>
		</ul>
	</div>
</nav>