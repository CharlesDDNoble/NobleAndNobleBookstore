<?php
if (isset($_POST['remove'])) { //REMOVE FROM CART
    try {
    $pdo->beginTransaction();
    $sql = $pdo->prepare("DELETE FROM UserShoppingCart WHERE `ISBN-13`=? LIMIT 1");
    $sql->bindValue(1,$_POST['remove']);
    $sql->execute();
    $pdo->commit();
    } catch(Exception $e) {
        $pdo->rollBack();
        $status = -11;
    }
}
?>