<?php
session_start();
require 'db.php';
if(isset($_SESSION['user_name'])){

if(isset($_GET['id']) && is_numeric($_GET['id'])){

    $stmt = $con->prepare("SELECT * FROM students where id = ?");
    $stmt->execute(array($_GET['id']));
    $result =$stmt->fetch();


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
        $arr_error['name'] = "Name must be not Empty";
    }
    if(empty($nat_id)){
        $arr_error['nat_id'] = "National ID must be Not Empty";

    }
    if($branch_id == 0){
        $arr_error['branch'] = "Branch Must Be not Empty";
    }

    if($speical_id == 0){
        $arr_error['speical'] = "specialization Must Be not Empty";
    }

    if($level == 0){
        $arr_error['level'] = "Level Must Be not Empty";
    }

    if(empty($arr_error)){

        if($numlength != 14){
        $arr_error['nat_id'] = "National ID Must be 14 numbers";
        $defalut = $_POST;
        }
        if(empty($arr_error)){
            $stmt =$con->prepare("SELECT * From students Where national_id = ? AND id != ?");
            $stmt->execute(array($nat_id,$_GET['id']));
            $result = $stmt->rowCount();
            if($result){
                $arr_error['error_in_add'] = "National Id is already Exist";
                $defalut = $_POST;
            }else{
                $stmt = $con->prepare("UPDATE students SET national_id = ? , `name` = ?,branch_id = ? , speical_id  = ?, `level` = ? WHERE id = ?");
                $stmt->execute(array($nat_id,$name,$branch_id,$speical_id,$level,$_GET['id']));
                $result = $stmt->rowCount();
                if($result){
                    header("location:Evaluation.php");
                }
            }

        }
    }

}

$stmt = $con->prepare("SELECT * FROM branchs");
$stmt->execute();
$all_branches = $stmt->fetchAll();

$stmt = $con->prepare("SELECT * FROM specializations");
$stmt->execute();
$all_specializations = $stmt->fetchAll();


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