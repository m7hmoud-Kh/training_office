<?php

require './models/Model_student.php';
require './static_message.php';
if($_SERVER["REQUEST_METHOD"] == "POST"){


  $arr_error = array();

  $nat_id = $_POST['nat_id'];

  if(empty($nat_id)){
    $arr_error['nat_id'] = $student['empty_nat_id'];
  }else{
    if(strlen($nat_id) != 14){
      $arr_error['nat_id'] = $student['not_14_nat_id'];
    }
  }

  if(empty($arr_error)){
    $result = get_student_by_nat_id($nat_id);
    if($result){
      $id =  $result['id'];
      header("location:selected_school_coor.php?id=$id");
    }
  }



}



?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <link href="css/coordination.css" rel="stylesheet" />
    <link href="css/header.css" rel="stylesheet" />

    <title>Coordination</title>
  </head>
  <body>
  <?php
  require 'header.php';
  ?>
    <form name="coordination" class="form" action="<?= $_SERVER["PHP_SELF"] ?>" method="POST">
      <h1>التنسيق</h1>

      <?php
          if(isset($arr_error)){
          foreach($arr_error as $err){
            ?>
          <small style="color: red;"><?=$err ?></small> <br>
          <?php
          }
        }
          ?>

      <label class="label">الرقم القومي</label>
      <input
        type="text"
        name="nat_id"
        maxlength="14"
        class="input1"
      /><br />
      <input type="submit" class="input1" value="أرسال" />
    </form>
  </body>
</html>
