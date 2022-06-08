<?php

require 'db.php';


function get_student_by_id($id){
    global $con;
    $stmt = $con->prepare("SELECT * FROM students where id = ?");
    $stmt->execute(array($id));
    return $stmt->fetch();
}


function get_duplicate_national_id($nat_id,$id){
    global $con;
    $stmt =$con->prepare("SELECT * From students Where national_id = ? AND id != ?");
    $stmt->execute(array($nat_id,$id));
    return $stmt->rowCount();
}


function update_student($nat_id,$name,$branch_id,$speical_id,$level,$id){
    global $con;
    $stmt = $con->prepare("UPDATE students SET national_id = ? , `name` = ?,branch_id = ? , speical_id  = ?, `level` = ? WHERE id = ?");
    $stmt->execute(array($nat_id,$name,$branch_id,$speical_id,$level,$id));
    return  $stmt->rowCount();
}

function get_student_is_coordination($id,$count = False){
    global $con;
    $stmt = $con->prepare("SELECT * FROM student_school where id = ?");
    $stmt->execute(array($id));
    return $count ? $stmt->rowCount() : $stmt->fetch();
}

function get_studnet_is_coordination_by_student_id($id,$count = False){
    global $con;
    $stmt = $con->prepare("SELECT * FROM student_school where student_id = ?");
    $stmt->execute(array($id));
    return $count ? $stmt->rowCount() : $stmt->fetch();
}

function get_check_group_in_school($branch_id){
    global $con;

    $stmt = $con->prepare("SELECT COUNT(special_id) as count_special , special_id ,school_id FROM student_school WHERE  branch_id = ? GROUP BY school_id");
    $stmt->execute(array($branch_id));
    return  $stmt->fetchAll();
}


function add_student_to_school($student_id,$school_id,$speical_id,$branch_id){
    global $con;
    $stmt = $con->prepare("INSERT INTO student_school (`student_id`, `school_id`, `special_id`, `branch_id`) VALUES (? , ? , ?,?)");
    $stmt->execute(array($student_id,$school_id,$speical_id,$branch_id));
    return $stmt->rowCount();
}

function get_student_by_nat_id($nat_id,$count = false){
    global $con;
    $stmt = $con->prepare("SELECT * FROM students where national_id  = ?");
    $stmt->execute(array($nat_id));
    return $count ? $stmt->rowCount() : $stmt->fetch();
}
