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
            $stmt =$con->prepare("SELECT * From students Where national_id = ? AND id != ?");
            $stmt->execute(array($nat_id,$_GET['id']));
            $result = $stmt->rowCount();
            if($result){
                $arr_error['error_in_add'] = "National Id is already Exist";
                $defalut = $_POST;
            }else{
                $stmt = $con->prepare("UPDATE students SET national_id = ? , `name` = ?,branchs = ? , `level` = ? WHERE id = ?");
                $stmt->execute(array($nat_id,$name,$branch,$level,$_GET['id']));
                $result = $stmt->rowCount();
                if($result){
                    header("location:Evaluation.php");
                }
            }

        }
    }

}



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
                    <input type="text" name="branch" value="<?= $result['branchs'] ?? '' ?>" /><br />
                    <label>الفرقة </label><br />
                    <input type="text" name="level" value="<?= $result['level'] ?? '' ?>" /><br />
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