<?php
require './models/Model_student.php';
if(isset($_GET['id']) && is_numeric($_GET['id'])){
    $result = delete_student_with_id($_GET['id']);
    if($result){
        header("location:Evaluation.php");
    }
}