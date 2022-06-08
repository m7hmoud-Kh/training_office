<?php

require 'db.php';


function is_poll_student_or_not($student_id){
    global $con;
    $stmt = $con->prepare("SELECT * FROM  polls where student_id   = ?");
    $stmt->execute(array($student_id));
    return $stmt->rowCount();
}


function insert_poll_one_section($section,$std_id,$school_id,$section_id){

    global $con;
    foreach($section as $key => $val){
        $stmt = $con->prepare("INSERT INTO polls (`student_id`,school_id,section_id,answer) VALUES(?,?,?,?)");
        $stmt->execute(array($std_id,$school_id,$section_id,$val));
    }
    return True;
}