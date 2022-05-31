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

        $stmt = $con->prepare("SELECT * FROM students where national_id  = ?");
        $stmt->execute(array($nat_id));
        $found_or_not = $stmt->fetch();
        if($found_or_not){

            $stmt = $con->prepare('SELECT * From  student_school  where student_id = ? ');
            $stmt->execute(array($found_or_not['id']));
            $result = $stmt->fetch();
            if($result){
                $id =  $result['id'];
                header("location:poll.php?id=$id");
            }else{
                $arr_error['not_checked'] = "Student don't Coordination yet..!";
            }
        }else{
            $arr_error['not_checked'] = "Maybe Incorrect National ID";
        }
    }

}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link href="./css/National ID.css" rel="stylesheet">
    <link href="./css/header.css" rel="stylesheet">
    <title>National ID</title>
</head>

<body dir="rtl">
<?php
  require 'header.php';
  ?>
    <form class="form" method="POST">
        <div id="mother">
            <div id="content">
                <h1>تقييم التدريب الميداني</h1>
                <?php
                if(isset($arr_error)){
                    foreach($arr_error as $err){
                    ?>
                        <small style="color: red;"><?=$err ?></small> <br>
                    <?php
                    }
                }
                ?>
            </div>
            <input type="text" class="input1" name="nat_id" placeholder="ادخل الرقم القومي"><br><br>
            <button type="submit">أرسال</button>
        </div>
    </form>
</body>

</html>