<?php
session_start();
if(isset($_SESSION['user_name'])){
require 'db.php';
require './static_message.php';
require './models/Model_student.php';
require './models/Model_branch.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $arr_error = array();
    $defalut = array();

  $name = htmlentities($_POST['name']);
  $nat_id = filter_var($_POST['nat_id'],FILTER_VALIDATE_INT);
  $level = htmlentities($_POST['level']);
  $branch_id = filter_var($_POST['branch_id'],FILTER_VALIDATE_INT);
  $gender = filter_var($_POST['gender'],FILTER_VALIDATE_INT);
  $speical_id =  filter_var($_POST['speical_id'],FILTER_VALIDATE_INT);


  $numlength = strlen((string)$nat_id);

  if(empty($name)){
    $arr_error['name'] = $student['empty_name'];
  }
  if(empty($nat_id)){
    $arr_error['nat_id'] = $student['empty_nat_id'];

  }

  if($branch_id == 0){
    $arr_error['branch_id'] = $student['empty_branch'];
  }

  if($speical_id == 0){
    $arr_error['speical_id'] = $student['empty_speical'];
  }

  if(empty($level)){
    $arr_error['level'] = $student['empty_level'];
  }

  if(empty($arr_error)){


    if($numlength != 14){
      $arr_error['nat_id'] = $student['not_14_nat_id'];
      $defalut = $_POST;

    }

    if(empty($arr_error)){
    $result = get_student_by_nat_id($nat_id,true);
    if($result){
      $arr_error['error_in_add'] = $student['dulicate_nat_id'];
      $defalut = $_POST;
    }else{
      add_student($nat_id,$name,$branch_id,$speical_id,$level,$gender);
    }

    }



  }

}

$result  = get_all_student();
$all_branches = get_all_branch();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <link href="css/Evaluation.css" rel="stylesheet" />
  <link href="css/header.css" rel="stylesheet" />

  <title>Evaluation</title>
</head>

<body dir="rtl">


<?php
require 'header_admin.php';
?>



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
          <select name="branch_id">
            <option value="0">--اختر الشعبه---</option>
            <?php
              foreach($all_branches as $branch){
                ?>
            <option value="<?=$branch['id']?>"><?=$branch['name']?></option>
            <?php
              }
            ?>
          </select>
          <br>

          <label>التخصص </label><br />
          <select name="speical_id">
            <option value="0">--اختر التخصص---</option>
            <option value="1">عام</option>
            <option value="2">اساسي</option>
            <option value="3">عام</option>

          </select>
          <br>

          <label>الفرقة </label><br />
          <select name="level">
            <option value="3">3</option>
            <option value="4">4</option>
          </select>
          <br>
          <label>النوع </label><br />
          <select name="gender">
            <option value="0" selected>ذكر</option>
            <option value="1">انثي</option>
          </select>
          <br>

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

        $stmt = $con->prepare("SELECT * FROM  branchs WHERE id = ?");
        $stmt->execute(array($std['branch_id']));
        $name_branch = $stmt->fetch();

        ?>
      <tr>
        <td><?=$std['name']?></td>
        <td><?= $std['national_id'] ?></td>
        <td><?= $name_branch['name'] ?></td>
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