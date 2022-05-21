<?php
session_start();
if(isset($_SESSION['user_name'])){
require 'db.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $arr_error = array();
    $defalut = array();

  $name = htmlentities($_POST['name']);
  $nat_id = filter_var($_POST['nat_id'],FILTER_VALIDATE_INT);
  $branch = htmlentities($_POST['branch']);
  $level = htmlentities($_POST['level']);


  $numlength = strlen((string)$nat_id);

  if(empty($name)){
    $arr_error['name'] = "Name must be not Empty";
  }
  if(empty($nat_id)){
    $arr_error['nat_id'] = "National ID must be Not Empty";

  }
  if(empty($branch)){
    $arr_error['branch'] = "Branch Must Be not Empty";
  }

  if(empty($level)){
    $arr_error['level'] = "Level Must Be not Empty";
  }

  if(empty($arr_error)){


    if($numlength != 11){
      $arr_error['nat_id'] = "National ID Must be 11 numbers";
      $defalut = $_POST;

    }

    if(empty($arr_error)){
    $stmt =$con->prepare("SELECT * From students Where national_id = ?");
    $stmt->execute(array($nat_id));
    $result = $stmt->rowCount();
    if($result){
      $arr_error['error_in_add'] = "National Id is already Exist";
      $defalut = $_POST;
    }else{
      $stmt = $con->prepare("INSERT INTO students (`national_id`, `name`, `branchs`, `level`) Values(?,?,?,?)");
      $stmt->execute(array($nat_id,$name,$branch,$level));
    }

    }



  }

}
$stmt =$con->prepare("SELECT * From students");
$stmt->execute();
$result = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <link href="css/Evaluation.css" rel="stylesheet" />
  <title>Evaluation</title>
</head>

<body dir="rtl">
  <div id="mother">
    <form name="Evaluation" class="form" action="<?= $_SERVER["PHP_SELF"] ?>" method="POST">
      <aside>
        <div>
          <h3>اضافه طالب</h3>
          <?php
          if(isset($arr_error)){
          foreach($arr_error as $err){
            ?>
          <small style="color: red;"><?=$err ?></small> <br>
          <?php
          }
        }
          ?>
          <br />
          <label>اسم الطالب </label><br />
          <input type="text" name="name" value="<?= $defalut['name'] ?? '' ?>" /><br />
          <label> الرقم القومي </label><br />
          <input type="number" name="nat_id" value="<?= $defalut['nat_id'] ?? '' ?>" /><br />
          <label>الشعبه </label><br />
          <input type="text" name="branch" value="<?= $defalut['branch'] ?? '' ?>" /><br />
          <label>الفرقة </label><br />
          <input type="text" name="level" value="<?= $defalut['level'] ?? '' ?>" /><br />
          <button type="submit" name="add">أضافة طالب</button>
    </form>
  </div>
  </aside>
  <main>
    <table id="tbl">
      <tr>
        <th>اسم الطالب</th>
        <th>الرقم القومي</th>
        <th>الشعبة</th>
        <th>الفرقة</th>
        <th>عمليات</th>
      </tr>
      <?php
      foreach($result as $std){
        ?>
      <tr>
        <td><?=$std['name']?></td>
        <td><?= $std['national_id'] ?></td>
        <td><?= $std['branchs'] ?></td>
        <td><?= $std['level']?></td>
        <td>
          <a href="update_student.php?id=<?=$std['id']?>">
            <button> Update </button>
          </a>
          <a href="delete_student.php?id=<?=$std['id']?>"><button>Delete</button></a>
        </td>
      </tr>
      <?php
      }
      ?>
    </table>
  </main>

  </div>
</body>

</html>
<?php
}
else{
  header("location:login.php");
}