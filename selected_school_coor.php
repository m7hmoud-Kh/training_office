<?php
require 'helper.php';
require './models/Model_student.php';
require './models/Model_branch.php';
require './models/Model_specializations.php';
require './models/Model_school.php';
require './static_message.php';

const TOTAL_STUDENT_SPECIAL = 8;

if(isset($_GET['id']) && is_numeric($_GET['id'])){


    $check_entered = get_studnet_is_coordination_by_student_id($_GET['id'],true);
    if(!$check_entered){

    $result = get_student_by_id($_GET['id']);

    $gender = get_gender($result['gender']);


    $branch = get_branch_by_id($result['branch_id']);


    $special = get_specializations_by_id($result['speical_id']);

    $check_group_in_school = get_check_group_in_school($branch['id']);

    $blocked_school = array();
    foreach($check_group_in_school as $check_group){
        if($check_group['count_special'] >= TOTAL_STUDENT_SPECIAL){
            $blocked_school[] = $check_group['school_id'];
        }

    }

    if(!empty($blocked_school)){
        $ids = join("','",$blocked_school);

        if($special['name'] == 'أساسي'){
            $schools = get_not_block_school($result['speical_id'],$ids);
            }else{
            $schools = get_not_block_school_base_on_gander($result['speical_id'],$result['gender'],$ids);
        }
    }else{

        if($special['name'] == 'أساسي'){
            $schools = get_school_by_speical_id($result['speical_id']);
            }else{
            $schools = get_school_by_speical_id_and_gender($result['speical_id'],$result['gender']);
            }
    }

    if($_SERVER["REQUEST_METHOD"] == "POST"){

        $school_id =  filter_var($_POST['school_id'],FILTER_VALIDATE_INT);

        $student_school = add_student_to_school($result['id'],$school_id,$special['id'],$branch['id']);

        if($student_school){
            $success = $student['success_selected_school'];
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
}else{
    header("location:coordination.php");
}