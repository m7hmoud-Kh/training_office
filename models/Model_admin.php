<?php

require 'db.php';

function get_admin_by_email_and_password($email,$password){
    global $con;
    $stmt = $con->prepare("SELECT * FROM admins Where email = ? And `password` = ?");
    $stmt->execute(array($email,$password));
    return $stmt->fetch();
}