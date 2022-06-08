<?php
session_start();
require './models/Model_student.php';
require './models/Model_branch.php';
require './models/Model_specializations.php';
require 'static_message.php';

if(isset($_SESSION['user_name'])){

if(isset($_GET['id']) && is_numeric($_GET['id'])){

$result =  get_student_by_id($_GET['id']);

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $arr_error = array();
    $defalut = array();
    $name = htmlentities($_POST['name']);
    $nat_id = filter_var($_POST['nat_id'],FILTER_VALIDATE_INT);
    $branch_id = htmlentities($_POST['branch_id']);
    $level = htmlentities($_POST['level']);
    $speical_id =  filter_var($_POST['speical_id'],FILTER_VALIDATE_INT);

    $numlength = strlen((string)$nat_id);

    if(empty($name)){
        $arr_error['name'] = $student['empty_name'];
    }
    if(empty($nat_id)){
        $arr_error['nat_id'] = $student['empty_nat_id'];

    }
    if($branch_id == 0){
        $arr_error['branch'] = $student['empty_branch'];
    }

    if($speical_id == 0){
        $arr_error['speical'] = $student['empty_speical'];
    }

    if($level == 0){
        $arr_error['level'] = $student['empty_level'];
    }



    if(empty($arr_error)){

        if($numlength != 14){
        $arr_error['nat_id'] = $student['not_14_nat_id'];
        $defalut = $_POST;
        }
        if(empty($arr_error)){
            $result = get_duplicate_national_id($nat_id,$_GET['id']);
            if($result){
                $arr_error['error_in_add'] = $student['dulicate_nat_id'];
                $defalut = $_POST;
            }else{
                $result = update_student($nat_id,$name,$branch_id,$speical_id,$level,$_GET['id']);
                if($result){
                    header("location:Evaluation.php");
                }
            }

        }
    }

    

}

$all_branches = get_all_branch();
$all_specializations = get_all_specializations();


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
        <form name="Evaluation" class="form" action="<?= $_SERVER["PHP_SELF"] ?>?id=<?=$_GET['id']?>" method="POST">
            <aside>
                <div>
                    <h3>تعديل طالب</h3>
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
                    <input type="text" name="name" value="<?= $result['name'] ?? '' ?>" /><br />
                    <label> الرقم القومي </label><br />
                    <input type="number" name="nat_id" value="<?= $result['national_id'] ?? '' ?>" /><br />
                    <label>الشعبه </label><br />
                    <select name="branch_id">
                        <option value="0">--اختر الشعبه---</option>
                        <?php
                        foreach($all_branches as $branch){
                        ?>
                        <option value="<?=$branch['id']?>" <?php
                            if($result['branch_id'] == $branch['id']){
                                ?> Selected <?php
                            }
                            ?>><?=$branch['name']?></option>
                        <?php
                        }
                        ?>
                    </select>
                    <br>

                    <label>التخصص </label><br />
                    <select name="speical_id">
                        <option value="0">--اختر التخصص---</option>
                        <?php
                        foreach($all_specializations as $spcial){
                        ?>
                        <option value="<?=$spcial['id']?>" <?php
                            if($result['speical_id'] == $spcial['id']){
                                ?> Selected <?php
                            }
                            ?>><?=$spcial['name']?></option>
                        <?php
                        }
                        ?>
                    </select>
                    <br>


                    <label>الفرقة </label><br />
                    <select name="level">
                        <option value="3"
                        <?php
                            if($result['speical_id'] == 3){
                                ?> Selected <?php
                            }
                            ?>
                        >3</option>
                        <option value="4"
                        <?php
                            if($result['speical_id'] == 4){
                                ?> Selected <?php
                            }
                            ?>>4</option>
                    </select>
                    <br>

                    <label>النوع </label><br />
                    <select name="gender">
                        <option value="0" <?php
                        if($result['gender'] == 0){echo 'Selected';}  ?>>ذكر</option>
                        <option value="1" <?php
                        if($result['gender'] == '1'){ echo 'selected';}  ?>>انثي</option>
                    </select>
                    <br>


                    <button type="submit" name="add">تعديل طالب</button>
        </form>
    </div>
    </aside>

</body>

</html>


<?php
    }

}else{
    header("location:login.php");
}