<?php
require 'db.php';
require 'helper.php';
if(isset($_GET['id']) && is_numeric($_GET['id'])){


$stmt = $con->prepare("SELECT * FROM student_school where id = ?");
$stmt->execute(array($_GET['id']));
$result = $stmt->fetch();


$stmt = $con->prepare("SELECT * FROM students where id = ?");
$stmt->execute(array($result['student_id']));
$student = $stmt->fetch();

$stmt = $con->prepare("SELECT `name` FROM branchs where id = ?");
$stmt->execute(array($result['branch_id']));
$branch = $stmt->fetch();


$stmt = $con->prepare("SELECT `name` FROM specializations where id = ?");
$stmt->execute(array($result['special_id']));
$special = $stmt->fetch();

$stmt = $con->prepare("SELECT `name` FROM schools  where id = ?");
$stmt->execute(array($result['school_id']));
$school = $stmt->fetch();



$gender = get_gender($student['gender']);






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
        <form name="coordination" class="form">
            <h1>نتيجه التنسيق</h1>
            <h3>الاسم : <?= $student['name']?></h3>
            <h3>النوع : <?= $gender?></h3>
            <h3>الرقم القومي : <?= $student['national_id']?></h3>
            <h3>الشعبه : <?= $branch['name']?></h3>
            <h3>التخصص : <?= $special['name']?></h3>
            <h3>المدرسه : <?= $school['name']?></h3>
        </form>
    </body>

    </html>

