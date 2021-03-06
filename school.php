<?php
session_start();
if(isset($_SESSION['user_name'])){
require 'db.php';
require 'helper.php';
require './static_message.php';
require './models/Model_school.php';
require './models/Model_specializations.php';


if($_SERVER["REQUEST_METHOD"] == "POST"){

  $arr_error = array();

  $name = htmlentities($_POST['name']);
  $gender = filter_var($_POST['gender'],FILTER_VALIDATE_INT);
  $special_id =  filter_var($_POST['special_id'],FILTER_VALIDATE_INT);


  if(empty($name)){
    $arr_error['name'] = $school['empty_name'];
  }


  if($special_id == 0){
    $arr_error['special_id'] = $school['empty_speical'];
  }

  if($gender == 2){
    $gender = null;
  }

  if(empty($arr_error)){

    $found_or_not = exist_school_or_not($name);
    if($found_or_not){
      $result = add_school($name,$special_id,$gender);
    }else{
      $arr_error['dublicated'] = $school['duplicate_name'];
    }

  }



}
$all_schools = get_all_school();


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <link href="css/Schools.css" rel="stylesheet" />
  <link href="css/header.css" rel="stylesheet" />

  <title>Schools</title>
</head>

<body dir="rtl">
  <?php
  require 'header_admin.php';
  ?>
  <div id="mother">
    <div id="content">
      <h1>أضافة مدرسة</h1>
    </div>
    <form class="form" action="<?= $_SERVER["PHP_SELF"] ?>" method="POST">
      <aside>
      <?php
          if(isset($arr_error)){
            foreach($arr_error as $err){
                ?>
                <small style="color: red;"><?=$err ?></small> <br>
                <?php
                }
          }
          ?>
        <label>اسم المدرسة</label><br />
        <input type="text" name="name" placeholder="اسم المدرسة"  /><br />
        <label>التخصص</label><br />
        <select name="special_id">
          <option value="0">--اختر التخصص--</option>
          <option value="1">عام</option>
          <option value="2">اساسي</option>
          <option value="3">البرنامج الخاص</option>
        </select><br />
        <label>النوع</label><br />
        <select name="gender">
          <option value="0">ذكور</option>
          <option value="1">اٍناث</option>
          <option value="2">مشتركه</option>
        </select><br />
        <button type="submit">أضافة مدرسة</button>
      </aside>
      </form>
      <main>
        <table id="tbl">
          <tr>
            <th>اسم المدرسة</th>
            <th>التخصص</th>
            <th>النوع</th>
            <th>عمليات</th>
          </tr>
          <?php
          foreach($all_schools as $school){
            $speical = get_specializations_by_id($school['speical_id']);

            $gender = get_gender($school['gender'])
            ?>
            <tr>
              <td><?=$school['name']?></td>
              <td><?=$speical['name']?></td>
              <td><?=$gender?></td>
              <td>
                <a href="update_school.php?id=<?=$school['id']?>">
                  <button> تعديل </button>
                </a>
                <a href="delete_school.php?id=<?=$school['id']?>"><button>حذف</button></a>
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
}else{
  header("location:login.php");
}