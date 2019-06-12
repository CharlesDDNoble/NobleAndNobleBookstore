                <?php
                    echo "<form method=\"get\" action=\"./catalog.php\">";
                    echo"    <div class=\"panel-group\">";
                    echo"        <div class=\"panel panel-success\">";
                    echo"	        <div class=\"panel-heading\">Sort By</div>";
                                
                    $sortType = array("Title", "Author", "Price");
                    
                    echo "<input type=\"radio\" value=\"Any\" name=\"type\" checked hidden>";
                    
                    foreach($sortType as $type) {
                        if ($_GET['type'] == $type)
                               echo "<div class=\"panel-body\"><input type=\"radio\" value=\"$type\" name=\"type\" checked> $type</div>";
                        else
                            echo "<div class=\"panel-body\"><input type=\"radio\" value=\"$type\" name=\"type\"> $type</div>";
                    }
                    
                    echo "      <div class=\"panel-heading\">Sort Type</div>";
                                
                    $sortOrder = array("ASC", "DESC");
                    
                    echo "<input type=\"radio\" value=\"Any\" name=\"order\" checked hidden>";
                    
                    foreach($sortOrder as $order) {
                        if ($_GET['order'] == $order)
                            echo "<div class=\"panel-body\"><input type=\"radio\" value=\"$order\" name=\"order\" checked> $order</div>";
                        else
                            echo "<div class=\"panel-body\"><input type=\"radio\" value=\"$order\" name=\"order\"> $order</div>";
                    }
                    	    
                    echo "<div class=\"panel-heading\">Search by Genre</div>";
                    echo "<input type=\"radio\" value=\"Any\" name=\"genre\" checked hidden>";
                    	        
                    $genreNames = $pdo->query("SELECT GenreName FROM Genre")->fetchAll();
                	
                	echo "<div class=\"panel-body\"><input type=\"radio\" value=\"Any\" name=\"genre\" checked> Any</div>";
                    
                    foreach($genreNames as $genre) {
                        if ($_GET['genre'] == $genre[0]) 
                            echo "<div class=\"panel-body\"><input type=\"radio\" value=\"$genre[0]\" name=\"genre\" checked> $genre[0]</div>";
                         else
                            echo "<div class=\"panel-body\"><input type=\"radio\" value=\"$genre[0]\" name=\"genre\"> $genre[0]</div>";
                    }
                            
                    echo "<div class=\"panel-body\"><button class=\"btn btn-full btn-success\" style=\"width: 100%; margin: auto; margin-top: 0px; \" type=\"submit\">Submit</button></div>";
                    echo "</div>";
                    echo "</div>";
                	echo "</form>";
            	?>