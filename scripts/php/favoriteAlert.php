<?php
if ($status == -1) {
    echo "<div id=\"update-alert\" class=\"alert alert-danger alert-dismissible fade in show\"" .
                 " style=\" width: 50%; margin: 0 auto 20px auto; text-align: center;\" role=\"alert\">";
    echo "An error occurred processing your request.";
    echo "</div>";
} else if ($status == 1) {
    echo "<div id=\"update-alert\" class=\"alert alert-success alert-dismissible fade in show\"" .
         " style=\" width: 50%; margin: 0 auto 20px auto; text-align: center;\" role=\"alert\">";
    echo "Item favorited!";
    echo "</div>";
} else if ($status == 2) {
    echo "<div id=\"update-alert\" class=\"alert alert-success alert-dismissible fade in show\"" .
         " style=\" width: 50%; margin: 0 auto 20px auto; text-align: center;\" role=\"alert\">";
    echo "Item unfavorited!";
    echo "</div>";
}
?>