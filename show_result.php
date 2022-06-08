<?php
require 'db.php';
require 'helper.php';
require './models/Model_student.php';
require './models/Model_school.php';
require './models/Model_branch.php';
require './models/Model_specializations.php';

if(isset($_GET['id']) && is_numeric($_GET['id'])){


$result = get_student_is_coordination($_GET['id']);
$student = get_student_by_id($result['student_id']);
$branch = get_branch_by_id($result['branch_id'],'name');
$special = get_specializations_by_id($result['special_id'],'name');
$school = get_school_by_id($result['school_id'],'name');
$gender = get_gender($student['gender']);

}

?>

<!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8" />
        <link href="css/coordination.css" rel="stylesheet" />
        <link href="css/header.css" rel="stylesheet" />

        <title>Coordination</title>
    </head>

    <body>
    <?php
  require 'header.php';
  ?>
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

