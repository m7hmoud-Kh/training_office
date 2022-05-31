<?php
session_start();
if(isset($_SESSION['user_name'])){
require 'db.php';

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
    $arr_error['name'] = "Name must be not Empty";
  }
  if(empty($nat_id)){
    $arr_error['nat_id'] = "National ID must be Not Empty";

  }

  if($branch_id == 0){
    $arr_error['branch_id'] = "Must be Select Branch";
  }

  if($speical_id == 0){
    $arr_error['speical_id'] = "Must be Select Branch";
  }

  if(empty($level)){
    $arr_error['level'] = "Level Must Be not Empty";
  }

  if(empty($arr_error)){


    if($numlength != 14){
      $arr_error['nat_id'] = "National ID Must be 14 numbers";
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

      $stmt = $con->prepare("INSERT INTO students (`national_id`, `name`, `branch_id`,speical_id, `level`,gender) Values(?,?,?,?,?,?)");
      $stmt->execute(array($nat_id,$name,$branch_id,$speical_id,$level,$gender));
    }

    }



  }

}
$stmt =$con->prepare("SELECT * From students");
$stmt->execute();
$result = $stmt->fetchAll();

$stmt = $con->prepare("SELECT * FROM branchs");
$stmt->execute();
$all_branches = $stmt->fetchAll();
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