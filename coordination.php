<?php

require 'db.php';
if($_SERVER["REQUEST_METHOD"] == "POST"){


  $arr_error = array();

  $nat_id = $_POST['nat_id'];

  if(empty($nat_id)){
    $arr_error['nat_id'] = "National ID Must be Added";
  }else{
    if(strlen($nat_id) != 14){
      $arr_error['nat_id'] = "National ID Must be 14 Numbers";
    }
  }

  if(empty($arr_error)){

    $stmt = $con->prepare('SELECT national_id ,id From students where national_id = ? ');
    $stmt->execute(array($nat_id));
    $result = $stmt->fetch();
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
    <title>Coordination</title>
  </head>
  <body>
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
