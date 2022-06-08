<?php

require 'db.php';

function get_all_specializations(){
    global $con;
    $stmt = $con->prepare("SELECT * FROM specializations");
    $stmt->execute();
    return $stmt->fetchAll();
}

function get_specializations_by_id($id,$select='*'){
    global $con;
    $stmt = $con->prepare("SELECT `$select` FROM specializations where id = ?");
    $stmt->execute(array($id));
    return $stmt->fetch();
}