<?php
if (isset($_POST['favorite']) && !isset($_SESSION['uid'])) {
    header("Location: ./login.php"); 
} else if (isset($_POST['favorite'])) {
    try {
        $pdo->beginTransaction();
        $sql = $pdo->prepare("SELECT `ProductFavoriteID` FROM ProductFavorite WHERE UID=? AND `ISBN-13`=?");
        $sql->bindValue(1,$_SESSION['uid']);
        $sql->bindValue(2,$_POST['favorite']);
        $sql->execute();
        $favorite = $sql->fetch();
        
        //if the favorite doesnt exist
        if ($favorite === false) {
            $sql = $pdo->prepare("INSERT INTO ProductFavorite (UID, `ISBN-13`) VALUES (?,?)");
            $sql->bindValue(1,$_SESSION['uid']);
            $sql->bindValue(2,$_POST['favorite']);
            $sql->execute();
            $pdo->commit();
            $status = 1;
        } else {//the favorite exists, remove it
            $sql = $pdo->prepare("DELETE FROM ProductFavorite WHERE ProductFavoriteID=?");
            $sql->bindValue(1,$favorite[0]);
            $sql->execute();
            $pdo->commit();
            $status = 2;
        }
        
    } catch (Exception $e) {
        $status = -1;
        $pdo->rollBack();
    }
}
?>