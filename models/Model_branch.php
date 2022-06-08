<?php

require 'db.php';


function get_all_branch(){
    global $con;
    $stmt = $con->prepare("SELECT * FROM branchs");
    $stmt->execute();
    return $stmt->fetchAll();
}

function get_branch_by_id($id,$select='*'){
    global $con;
    $stmt = $con->prepare("SELECT `$select` FROM branchs where id = ?");
    $stmt->execute(array($id));
    return $stmt->fetch();
}