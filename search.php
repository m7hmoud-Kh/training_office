<?php

require './static_message.php';
require './models/Model_student.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){


  $arr_error = array();

  $nat_id = $_POST['nat_id'];

  if(empty($nat_id)){
    $arr_error['nat_id'] = $student['empty_nat'];
  }else{
    if(strlen($nat_id) != 14){
      $arr_error['nat_id'] = $student['not_14_nat_id'];
    }
  }

  if(empty($arr_error)){

    $found_or_not = get_student_by_nat_id($nat_id);

    if($found_or_not){

    $result = get_studnet_is_coordination_by_student_id($found_or_not['id']);
    if($result){
      $id =  $result['id'];
      header("location:show_result.php?id=$id");
    }else{
      $arr_error['not_checked'] = $student['not_Coordination'];
    }
  }else{
    $arr_error['not_checked'] = $student['incorrect_nat_id'];
  }

  }



}



?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <link href="css/search.css" rel="stylesheet" />
  <link href="css/header.css" rel="stylesheet" />

  <title>Search</title>
</head>

<body>
<?php
  require 'header.php';
  ?>
  <form class="form" action="<?= $_SERVER["PHP_SELF"] ?>" method="POST">
    <h1>نتيجة التنسيق</h1>
    <?php
          if(isset($arr_error)){
          foreach($arr_error as $err){
            ?>
    <small style="color: red;"><?=$err ?></small> <br>
    <?php
          }
        }
        ?>
    <input type="text" class="input1" name="nat_id" placeholder="ادخل الرقم القومي" /><br />

    <button type="submit">أرسال</button>
  </form>
</body>

</html>