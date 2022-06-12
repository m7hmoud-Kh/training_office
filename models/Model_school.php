<?php

require 'db.php';

function get_school_by_id($id){
    global $con;
    $stmt = $con->prepare("SELECT * FROM schools where id = ?");
    $stmt->execute(array($id));
    return $stmt->fetch();
}

function get_school_by_speical_id($special_id){
    global $con;
    $stmt = $con->prepare("SELECT * FROM  schools  where speical_id = ?");
    $stmt->execute(array($special_id));
    return $stmt->fetchAll();
}

function get_all_school(){
    global $con;
    $stmt = $con->prepare("SELECT * From schools");
    $stmt->execute();
    return $stmt->fetchAll();
}


function get_duplicate_name_school($name,$id){
    global $con;

    $stmt = $con->prepare("SELECT * From schools where `name` = ? AND id != ?");
    $stmt->execute(array($name,$id));
    return $stmt->rowCount();
}


function update_school($name,$special_id,$gender,$id){
    global $con;
    $stmt = $con->prepare("UPDATE schools set `name` = ? , speical_id = ? , gender = ?  Where id = ?");
    $stmt->execute(array($name,$special_id,$gender,$id));
    return $stmt->rowCount();
}




function get_not_block_school($speical_id,$ids){
    global $con;
    $stmt = $con->prepare("SELECT * FROM  schools  where speical_id = ? AND id not in (?) ");
    $stmt->execute(array($speical_id,$ids));
    return $stmt->fetchAll();
}

function get_not_block_school_base_on_gander($speical_id,$gender,$ids){
    global $con;

    $stmt = $con->prepare("SELECT * FROM schools where speical_id = ? AND gender = ? AND id Not in (?)");
    $stmt->execute(array($speical_id,$gender,$ids));
    return  $stmt->fetchAll();
}


function get_school_by_speical_id_and_gender($speical_id,$gender){
    global $con;
    $stmt = $con->prepare("SELECT * FROM schools where speical_id = ? AND gender = ? ");
    $stmt->execute(array($speical_id,$gender));
    return $stmt->fetchAll();
}


function exist_school_or_not($name){
    global $con;
    $stmt = $con->prepare("SELECT * From schools where `name` != ?");
    $stmt->execute(array($name));
    return  $stmt->rowCount();
}

function add_school($name,$special_id,$gender){
    global $con;
    $stmt = $con->prepare("INSERT INTO schools (`name`,speical_id,gender) VALUES(?,?,?)");
    $stmt->execute(array($name,$special_id,$gender));
    return $stmt->rowCount();
}

function delete_school_by_id($id){
    global $con;
    $stmt = $con->prepare("DELETE FROM schools Where id = ?");
    $stmt->execute(array($id));
    return $stmt->rowCount();
}