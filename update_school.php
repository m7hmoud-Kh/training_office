<?php
session_start();
if(isset($_SESSION['user_name'])){
require 'db.php';
require 'helper.php';

if(isset($_GET['id']) && is_numeric($_GET['id'])){

    $stmt = $con->prepare("SELECT * FROM schools where id = ?");
    $stmt->execute(array($_GET['id']));
    $result =$stmt->fetch();


if($_SERVER["REQUEST_METHOD"] == "POST"){

$arr_error = array();

$name = htmlentities($_POST['name']);
$gender = filter_var($_POST['gender'],FILTER_VALIDATE_INT);
$special_id =  filter_var($_POST['special_id'],FILTER_VALIDATE_INT);


if(empty($name)){
$arr_error['name'] = "Name must be not Empty";
}


if($special_id == 0){
$arr_error['special_id'] = "Must be Select Branch";
}

if($gender == 2){
$gender = null;
}

if(empty($arr_error)){


    $stmt = $con->prepare("SELECT * From schools where `name` = ? AND id != ?");
    $stmt->execute(array($name,$_GET['id']));
    $found_or_not = $stmt->rowCount();
    if(!$found_or_not){

        $stmt = $con->prepare("UPDATE schools set `name` = ? , speical_id = ? , gender = ?  Where id = ?");
        $stmt->execute(array($name,$special_id,$gender,$_GET['id']));
        $Updated = $stmt->rowCount();
        if($Updated){
            $success = "You Are Updated School Successfully";
            header('Refresh: 3; URL=school.php');
        }
    }else{
        $arr_error['dublicated'] = 'School is already Exists';
    }

}



}
$stmt = $con->prepare("SELECT * From schools");
$stmt->execute();
$all_schools = $stmt->fetchAll();


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <link href="css/Schools.css" rel="stylesheet" />
    <title>Schools</title>
</head>

<body dir="rtl">
    <div id="mother">
        <div id="content">
            <h1>تعديل مدرسة</h1>
        </div>
        <form class="form" action="<?= $_SERVER["PHP_SELF"] ?>?id=<?=$_GET['id']?>" method="POST">
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
                <input type="text" name="name" placeholder="اسم المدرسة" value="<?=$result['name']?>" /><br />
                <label>التخصص</label><br />
                <select name="special_id">
                    <option value="0">--اختر التخصص--</option>
                    <option value="1" <?php if($result['speical_id'] == '1' ){echo 'selected';} ?>>عام</option>
                    <option value="2" <?php if($result['speical_id'] == '2' ){echo 'selected';} ?>>اساسي</option>
                    <option value="3" <?php if($result['speical_id'] == '3' ){echo 'selected';} ?>>البرنامج الخاص</option>
                </select><br />
                <label>النوع</label><br />
                <select name="gender">
                    <option value="0" <?php if($result['gender'] == '0' ){echo 'selected';} ?>>ذكور</option>
                    <option value="1" <?php if($result['gender'] == '1' ){echo 'selected';} ?>>اٍناث</option>
                    <option value="2" <?php if($result['gender'] == null ){echo 'selected';} ?>>مشتركه</option>
                </select><br />
                <button type="submit">تعديل مدرسة</button> <br>

                <small style="color: green;"> <?= $success ?? '' ?> </small>
            </aside>
        </form>
    </div>
</body>

</html>
<?php
}
}else{
  header("location:login.php");
}