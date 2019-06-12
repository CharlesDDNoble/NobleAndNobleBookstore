<?php
session_start();


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
	<link rel="stylesheet" type="text/css" href="./css/index.css">

	<link rel="icon" type="image/png" href="images/logo.png">
	<title>Noble &amp; Noble</title>
	
</head>

<body>
	
	<!-- NAV BAR -->
	<?php include './scripts/php/nav.php'; ?>
    
	<div class="container">
		
		<div class="row">
			<div class="col-sm-12">
				<div id="content-holder" class="container">
					<div id="main-content" class="carousel slide" data-ride="carousel">
						<ol class="carousel-indicators">
							<li data-target="#main-content" data-slide-to="0" class="active"></li>
							<li data-target="#main-content" data-slid-to="1"></li>
							<li data-target="#main-content" data-slide-to="2"></li>
						</ol>

					  	<div class="carousel-inner">
					    	<div class="item active">
								<a href="./catalog.php?type=Title&order=ASC&genre=Romance"><img class="carousel-img" src="./images/carousel/heart.png" alt=""></a>
								<div class="carousel-caption">
                                    <h1 style="color: #ed664e;">Let your love blossom this Spring</h1>
                                    <h4 style="color: #ed664e;">Get your special someone one of these lovely books</h4>
                                </div>
					    	</div>

						    <div class="item">
						     	<a href="./catalog.php?type=Title&order=ASC&genre=Fantasy"><img class="carousel-img" src="./images/carousel/fantasy.jpg" alt=""></a>
						     	<div class="carousel-caption">
                                    <h1 style="color: white;">Fly you fools</h1>
                                    <h4 style="color: white;">And get lost in a fantasy adventure</h4>
                                </div>
						    </div>

						    <div class="item">
						      	<a href="./catalog.php?type=Title&order=ASC&genre=Classics"><img class="carousel-img" src="./images/carousel/classics.png" alt=""></a>
						      	<div class="carousel-caption">
                                    <h2 style="color: white;">Wherefore art thou... Classic books?</h2>
                                    <h4 style="color: white;">Here of course, Grab one a fantastic classic</h4>
                                </div>
						    </div>
					  	</div>

					  	<a class="left carousel-control" href="#main-content" data-slide="prev">
					    	<span class="glyphicon glyphicon-chevron-left"></span>
					    	<span class="sr-only">Previous</span>
					  	</a>
					  	
					  	<a class="right carousel-control" href="#main-content" data-slide="next">
					    	<span class="glyphicon glyphicon-chevron-right"></span>
					    	<span class="sr-only">Next</span>
					  	</a>
					</div>
				</div>


                <div class="container">
				<div style="margin-top: 20px;" class="row">

				<div class="col-lg-4 col-md-6 mb-6">
					<div class="panel panel-success">
						<a href="./catalog.php?type=Title&order=ASC&genre=Fantasy"><img class="panel-img" src="./images/card/fantasy.jpg" alt=""></a>
						<div class="panel-body">
							<h4><a href="./catalog.php?type=Title&order=ASC&genre=Fantasy">Fantasy</a></h4>
							<p>Fantasy is often characterized by a departure from the accepted rules 
							by which individuals perceive the world around them; it represents that which is 
							impossible (unexplained) and outside the parameters of our known, reality.
							Make-believe is what this genre is all about.</p>
						</div>
						<div>
							<br>
						</div>
					</div>
				</div>
			
				<div class="col-lg-4 col-md-6 mb-4">
					<div class="panel panel-success">
						<a href="./catalog.php?type=Title&order=ASC&genre=Children"><img class="panel-img" src="./images/card/children.png" alt=""></a>
						<div class="panel-body">
							<h4><a href="./catalog.php?type=Title&order=ASC&genre=Children">Children</a></h4>
							<p>Early Readers, Picture Books, Middle-Grade novels, and Young Adults; These books shape the minds
							of children everywhere. Whether its the zany and wacky Dr. Seuss or the precocious antics of Junie B. Jones, 
							these books will definitely leave a lasting impression on your child.</p>
						</div>
						<div>
							<br>
						</div>
					</div>
				</div>

				<div class="col-lg-4 col-md-6 mb-4">
					<div class="panel panel-success">
						<a href="./catalog.php?type=Title&order=ASC&genre=Classics"><img class="panel-img" src="./images/card/classics.jpg" alt=""></a>
						<div class="panel-body">
							<h4><a href="./catalog.php?type=Title&order=ASC&genre=Classics">Classics</a></h4>
							<p>A classic is accepted as exemplary or noteworthy, for example through an imprimatur such as being listed in a list of great books, or through a reader's personal opinion. Although often associated with Western canon, it can be applied to works of literature from all traditions.</p>
						</div>
						<div>
							<br>
						</div>
					</div>
				</div>

				<div class="col-lg-4 col-md-6 mb-4">
					<div class="panel panel-success">
						<a href="./catalog.php?type=Title&order=ASC&genre=Historical"><img class="panel-img" src="./images/card/historical.jpg" alt=""></a>
						<div class="panel-body">
							<h4><a href="./catalog.php?type=Title&order=ASC&genre=Historical">Historical Fiction</a></h4>
							<p>Historical novels can enable readers to experience the past vividly and to engage in historical drama. These experiences can stir up personal feelings of happiness, joy, pain, and despair as the reader enters the world of the characters and shares emotions felt by these characters.</p>
						</div>
						<div>
							<br>
						</div>
					</div>
				</div>

				<div class="col-lg-4 col-md-6 mb-4">
					<div class="panel panel-success">
						<a href="./catalog.php?type=Title&order=ASC&genre=Nonfiction"><img class="panel-img" src="./images/card/nonfiction.jpg" alt=""></a>
						<div class="panel-body">
							<h4><a href="./catalog.php?type=Title&order=ASC&genre=Nonfiction">Nonfiction</a></h4>
							<p>Nonfiction - is the opposite of fiction. Books that are Nonfiction, or true, are about real things, people, events, and places. Literary Nonfiction, Factual fiction, Documentary narrative, the literature of actuality. This powerful, ever-controversial genre is called by many names..</p>
						</div>
						<div>
							<br>
						</div>
					</div>
				</div>

				<div class="col-lg-4 col-md-6 mb-4">
					<div class="panel panel-success">
						<a href="./catalog.php?type=Title&order=ASC&genre=Romance"><img class="panel-img" src="./images/card/romance.jpg" alt=""></a>
						<div class="panel-body">
							<h4><a href="./catalog.php?type=Title&order=ASC&genre=Romance">Romance</a></h4>
							<p>Romantic Fiction is not only one of the most popular forms of fiction we have,
                                it is one of the oldest and most distinguished. If you count the medieval verses 
                                of courtly love, it pre-dates the novel by several centuries; if you count
                                Classical literature, Virgil's Aeneid and even the Odyssey could count.</p>
						</div>
						<div>
							<br>
						</div>
					</div>
				</div>

				<div class="col-lg-4 col-md-6 mb-4">
					<div class="panel panel-success">
						<a href="./catalog.php?type=Title&order=ASC&genre=Science+Fiction"><img class="panel-img" src="./images/card/scifi.jpg" alt=""></a>
						<div class="panel-body">
							<h4><a href="./catalog.php?type=Title&order=ASC&genre=Science+Fiction">Science Fiction</a></h4>
							<p>Science Fiction genre novels are literature about the future, telling stories of the marvels we hope to see, or for
							our descendants to see tomorrow, in the next century, or in the limitless duration of time. It doesn't just have to be 
							about science, though. It has been described quite suitably as: "A controlled way to think and dream about the future." 
							It can be about people, ideas, and where the world is going. It can also be about where people have already been.</p>
						</div>
						<div>
							<br>
						</div>
					</div>
				</div>

                

				</div>
				</div>
			</div> <!-- END OF COLUMN -->

		</div> <!-- END OF ROW -->



	</div> <!-- END OF SECTION -->

	
	<!-- jQuery  -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<!-- Bootstrap - JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<!-- Other Scripts -->
	<script src="./scripts/javascript/alertDismisser.js"></script>
</body>


</html>
			
