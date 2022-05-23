<?php
require 'db.php';
if(isset($_GET['id']) && is_numeric($_GET['id'])){

    $stmt = $con->prepare("DELETE FROM schools Where id = ?");
    $stmt->execute(array($_GET['id']));
    $result = $stmt->rowCount();
    if($result){
        header("location:school.php");
    }
}