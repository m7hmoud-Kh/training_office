<?php
session_start();
require "db.php";
require './static_message.php';
require './models/Model_admin.php';



if($_SERVER["REQUEST_METHOD"] == "POST"){


  $arr_error = array();
  $email =  filter_var($_POST["email"],FILTER_VALIDATE_EMAIL);
  $password = htmlentities($_POST['password']);


  if(empty($email)){
    $arr_error['email'] = $admin['empty_email'];
  }
  if(empty($password)){
    $arr_error['password'] = $admin['empty_password'];
  }


  if(empty($arr_error)){
    $result = get_admin_by_email_and_password($email,$password);
    if($result){
      $_SESSION['id'] = $result['id'];
      $_SESSION['user_name'] = $result['user_name'];
      $_SESSION['email'] = $result['email'];
      header('location:Evaluation.php');
    }else{
      $arr_error['error_in_login'] = $admin['error_in_login'];
    }
  }



}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <link href="css/login.css" rel="stylesheet" />
    <title>Login</title>
  </head>
  <body>
    <form class="form" action="<?= $_SERVER["PHP_SELF"] ?>" method="POST">
      <div class="img">
        <img src="img/img2.png" alt="" />
      </div>
      <br />
      <div>
        <label>E-mail</label><br />
        <input class="input1" type="text" name="email" placeholder="E-mail" />
        <small class="error" > <?= $arr_error['email'] ?? '' ?> </small>
      </div>
      <br />
      <div>
        <label>Password</label><br />
        <input
          class="input1"
          type="password"
          name="password"
          placeholder="password"
        />
        <small  class="error"> <?= $arr_error['password'] ?? '' ?> </small>

      </div>
      <br />

      <button class="input1" type="submit">Login</button>
      <br>
      <small class="error"><?= $arr_error['error_in_login'] ?? '' ?></small>
    </form>
  </body>
</html>
