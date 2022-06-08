<?php
require './models/Model_school.php';
if(isset($_GET['id']) && is_numeric($_GET['id'])){
    $result = delete_school_by_id($_GET['id']);
    if($result){
        header("location:school.php");
    }
}