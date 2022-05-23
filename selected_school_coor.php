<?php

require 'db.php';
if(isset($_GET['id']) && is_numeric($_GET['id'])){

//Check if student selected school or Not ( miss Requirment )

$stmt = $con->prepare("SELECT * FROM students where id = ?");
$stmt->execute(array($_GET['id']));
$result = $stmt->fetch();

if($result['gender'] == 1){
    $gender = 'انثي';
}else{
    $gender = 'ذكر';
}

$stmt = $con->prepare("SELECT * FROM branchs where id = ?");
$stmt->execute(array($result['branch_id']));
$branch = $stmt->fetch();


$stmt = $con->prepare("SELECT * FROM specializations where id = ?");
$stmt->execute(array($result['speical_id']));
$special = $stmt->fetch();

$stmt = $con->prepare("SELECT COUNT(special_id) as count_special , special_id ,school_id FROM student_school WHERE  branch_id = ? GROUP BY school_id");
$stmt->execute(array($branch['id']));
$check_group_in_school = $stmt->fetchAll();

$blocked_school = array();
foreach($check_group_in_school as $check_group){
    if($check_group['count_special'] >= 8){
        $blocked_school[] = $check_group['school_id'];
    }

}

if(!empty($blocked_school)){
    $ids = join("','",$blocked_school);

    if($special['name'] == 'أساسي'){
        $stmt = $con->prepare("SELECT * FROM  schools  where speical_id = ? AND id not in (?) ");
        $stmt->execute(array($result['speical_id'],$ids));
        $schools = $stmt->fetchAll();
        }else{
        $stmt = $con->prepare("SELECT * FROM schools where speical_id = ? AND gender = ? AND id Not in (?)");
        $stmt->execute(array($result['speical_id'],$result['gender'],$ids));
        $schools = $stmt->fetchAll();

    }

}else{

    if($special['name'] == 'أساسي'){
        $stmt = $con->prepare("SELECT * FROM  schools  where speical_id = ?");
        $stmt->execute(array($result['speical_id']));
        $schools = $stmt->fetchAll();
        }else{
        $stmt = $con->prepare("SELECT * FROM schools where speical_id = ? AND gender = ? ");
        $stmt->execute(array($result['speical_id'],$result['gender']));
        $schools = $stmt->fetchAll();
        }


}




if($_SERVER["REQUEST_METHOD"] == "POST"){

    $school_id =  filter_var($_POST['school_id'],FILTER_VALIDATE_INT);

    $stmt = $con->prepare("INSERT INTO student_school (`student_id`, `school_id`, `special_id`, `branch_id`) VALUES (? , ? , ?,?)");
    $stmt->execute(array($result['id'],$school_id,$special['id'],$branch['id']));
    $student_school = $stmt->rowCount();
    if($student_school){
        $success = "You Are Selected School Successfully";
        header('Refresh: 3; URL=coordination.php');
    }

}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <link href="css/coordination.css" rel="stylesheet" />
    <title>Coordination</title>
</head>

<body>
    <form name="coordination" class="form" action="<?= $_SERVER["PHP_SELF"] ?>?id=<?=$_GET['id']?>" method="POST">
        <h1>التنسيق</h1>
        <h3>name : <?= $result['name']?></h3>
        <h3>gender : <?= $gender?></h3>
        <h3>national Id : <?= $result['national_id']?></h3>
        <h3>branch : <?= $branch['name']?></h3>
        <h3>special : <?= $special['name']?></h3>


        <select name="school_id">
            <?php
            foreach($schools as $school){
                ?>
            <option value="<?=$school['id']?>"> <?=$school['name']?> </option>
            <?php
            }
            ?>
        </select>


        <input type="submit" class="input1" value="أرسال" />

        <small style="color: green;"> <?= $success ?? '' ?> </small>
    </form>
</body>

</html>
<?php
}else{
    header("location:coordination.php");
}