<?php

require 'db.php';
require 'helper.php';
if(isset($_GET['id']) && is_numeric($_GET['id'])){

    $stmt = $con->prepare("SELECT * FROM student_school  where id  = ?");
    $stmt->execute(array($_GET['id']));
    $student = $stmt->fetch();


    $stmt = $con->prepare("SELECT * FROM  polls where student_id   = ?");
    $stmt->execute(array($student['student_id']));
    $is_poll = $stmt->rowCount();
if(!$is_poll){

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $section_1 = array();
    $section_2 = array();
    $section_3 = array();

    foreach ($_POST as $key => $value) {
        $key_sub = substr($key,0,4);
        if($key_sub == 'sec1'){
            $section_1[$key] = $value;
        }elseif($key_sub == 'sec2'){
            $section_2[$key] = $value;
        }else{
            $section_3[$key] = $value;
        }
    }

    $added_section_1 = insert_poll_one_section($section_1,$student['student_id'],$student['school_id'],1);
    $added_section_2 = insert_poll_one_section($section_2,$student['student_id'],$student['school_id'],2);
    $added_section_3 = insert_poll_one_section($section_3,$student['student_id'],$student['school_id'],3);

    if($added_section_1 && $added_section_2 && $added_section_3){
        $success_poll = 'You Are Maked Poll Successfully';
        header('Refresh: 3; URL=home.php');
    }

}


?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link href="./css/Poll.css" rel="stylesheet">
    <link href="./css/header.css" rel="stylesheet">

    <title>Poll</title>
</head>

<body dir="rtl">
    <div id="mother">
        <div id="content">
            <h1>نموذج استمارة لاستقصاء آراء الطلاب في التدريب الميداني</h1>
            <h3 style="color: green;"> <?= $success_poll ?? '' ?> </h3>
        </div>
        <form class="form" method="POST" action="<?= $_SERVER["PHP_SELF"] ?>?id=<?=$_GET['id']?>">
            <div>
                <h2>أولا: رأي الطالب في أداء المشرف التربوي</h2>
                <label>1-كانت زيارات المشرف التربوي في الوقت المناسب ومفيدة.</label><br>
                {1<input type="radio" name="sec1_q1" value="1">
                2<input type="radio" name="sec1_q1" value="2">
                3<input type="radio" name="sec1_q1" value="3">
                4<input type="radio" name="sec1_q1" value="4">
                5<input type="radio" name="sec1_q1" value="5">}<br>
                <label>2-كانت ملاحظاته موضوعية ونزيهة.</label><br>
                {1<input type="radio" name="sec1_q2" value="1">
                2<input type="radio" name="sec1_q2" value="2">
                3<input type="radio" name="sec1_q2" value="3">
                4<input type="radio" name="sec1_q2" value="4">
                5<input type="radio" name="sec1_q2" value="5">}<br>
                <label>3-قدم الدعم والمساندة باستمرار</label><br>
                {1<input type="radio" name="sec1_q3" value="1">
                2<input type="radio" name="sec1_q3" value="2">
                3<input type="radio" name="sec1_q3" value="3">
                4<input type="radio" name="sec1_q3" value="4">
                5<input type="radio" name="sec1_q3" value="5">}<br>
                <label>4-كانت اجتماعاتنا معه بناءة ومثمرة.</label><br>
                {1<input type="radio" name="sec1_q4" value="1">
                2<input type="radio" name="sec1_q4" value="2">
                3<input type="radio" name="sec1_q4" value="3">
                4<input type="radio" name="sec1_q4" value="4">
                5<input type="radio" name="sec1_q4" value="5">}<br>
                <label>5-كانت تعليقاته على ملف الانجاز ومذكراتي مفيدة وفاعلة.</label><br>
                {1<input type="radio" name="sec1_q5" value="1">
                2<input type="radio" name="sec1_q5" value="2">
                3<input type="radio" name="sec1_q5" value="3">
                4<input type="radio" name="sec1_q5" value="4">
                5<input type="radio" name="sec1_q5" value="5">}<br>
                <label>6-تنميته لمهاراتي التدريسية.</label><br>
                {1<input type="radio" name="sec1_q6" value="1">
                2<input type="radio" name="sec1_q6" value="2">
                3<input type="radio" name="sec1_q6" value="3">
                4<input type="radio" name="sec1_q6" value="4">
                5<input type="radio" name="sec1_q6" value="5">}<br>
                <label>7-تعليقاته على خططي التدريسية ساهمت في تحسينها وتقدمي المهني.
                </label><br>
                {1<input type="radio" name="sec1_q7" value="1">
                2<input type="radio" name="sec1_q7" value="2">
                3<input type="radio" name="sec1_q7" value="3">
                4<input type="radio" name="sec1_q7" value="4">
                5<input type="radio" name="sec1_q7" value="5">}<br>
                <label>8-تعليقاته وتقييمه لأدائي التدريسي ساهموا في تحسينه ونموي المهني.</label><br>
                {1<input type="radio" name="sec1_q8" value="1">
                2<input type="radio" name="sec1_q8" value="2">
                3<input type="radio" name="sec1_q8" value="3">
                4<input type="radio" name="sec1_q8" value="4">
                5<input type="radio" name="sec1_q8" value="5">}<br>
                <label>9-أداؤه المهني عال ونزيه.</label><br>
                {1<input type="radio" name="sec1_q9" value="1">
                2<input type="radio" name="sec1_q9" value="2">
                3<input type="radio" name="sec1_q9" value="3">
                4<input type="radio" name="sec1_q9" value="4">
                5<input type="radio" name="sec1_q9" value="5">}<br>
            </div><br><br>
            <div>
                <h2>ثانيا: رأي الطالب في أداء المشرف الأكاديمي</h2>
                <label>1-كانت زيارات المشرف الأكاديمي في الوقت المناسب ومفيدة.</label><br>
                {1<input type="radio" name="sec2_q1" value="1">
                2<input type="radio" name="sec2_q1" value="2">
                3<input type="radio" name="sec2_q1" value="3">
                4<input type="radio" name="sec2_q1" value="4">
                5<input type="radio" name="sec2_q1" value="5">}<br>
                <label>2-كانت ملاحظاته موضوعية ونزيهة.</label><br>
                {1<input type="radio" name="sec2_q2" value="1">
                2<input type="radio" name="sec2_q2" value="2">
                3<input type="radio" name="sec2_q2" value="3">
                4<input type="radio" name="sec2_q2" value="4">
                5<input type="radio" name="sec2_q2" value="5">}<br>
                <label>3-قدم بالدعم والمساندة باستمرار.</label><br>
                {1<input type="radio" name="sec2_q3" value="1">
                2<input type="radio" name="sec2_q3" value="2">
                3<input type="radio" name="sec2_q3" value="3">
                4<input type="radio" name="sec2_q3" value="4">
                5<input type="radio" name="sec2_q3" value="5">}<br>
                <label>4-كانت اجتماعاتنا معه بناءة ومثمرة.</label><br>
                {1<input type="radio" name="sec2_q4" value="1">
                2<input type="radio" name="sec2_q4" value="2">
                3<input type="radio" name="sec2_q4" value="3">
                4<input type="radio" name="sec2_q4" value="4">
                5<input type="radio" name="sec2_q4" value="5">}<br>
                <label>5-كانت تعليقاته على ملف الانجاز ومذكراتي مفيدة وفاعلة.</label><br>
                {1<input type="radio" name="sec2_q5" value="1">
                2<input type="radio" name="sec2_q5" value="2">
                3<input type="radio" name="sec2_q5" value="3">
                4<input type="radio" name="sec2_q5" value="4">
                5<input type="radio" name="sec2_q5" value="5">}<br>
                <label>6-تنميته لمهاراتي التدريسية.</label><br>
                {1<input type="radio" name="sec2_q6" value="1">
                2<input type="radio" name="sec2_q6" value="2">
                3<input type="radio" name="sec2_q6" value="3">
                4<input type="radio" name="sec2_q6" value="4">
                5<input type="radio" name="sec2_q6" value="5">}<br>
                <label>7-تعليقاته على خططي التدريسية ساهمت في تحسينها وتقدمي المهني.</label><br>
                {1<input type="radio" name="sec2_q7" value="1">
                2<input type="radio" name="sec2_q7" value="2">
                3<input type="radio" name="sec2_q7" value="3">
                4<input type="radio" name="sec2_q7" value="4">
                5<input type="radio" name="sec2_q7" value="5">}<br>
                <label>8-تعليقاته وتقييمه لأدائي التدريسي ساهموا في تحسينه ونموي المهني.</label><br>
                {1<input type="radio" name="sec2_q8" value="1">
                2<input type="radio" name="sec2_q8" value="2">
                3<input type="radio" name="sec2_q8" value="3">
                4<input type="radio" name="sec2_q8" value="4">
                5<input type="radio" name="sec2_q8" value="5">}<br>
                <label>9-أداؤه المهني عال ونزيه.</label><br>
                {1<input type="radio" name="sec2_q9" value="1">
                2<input type="radio" name="sec2_q9" value="2">
                3<input type="radio" name="sec2_q9" value="3">
                4<input type="radio" name="sec2_q9" value="4">
                5<input type="radio" name="sec2_q9" value="5">}<br>
            </div><br><br>
            <div>
                <h2>ثالثا: رأي الطالب في أداء مدير المدرسة</h2>
                <label>1-كانت زيارات مدير المدرسة في الوقت المناسب ومفيدة.</label><br>
                {1<input type="radio" name="sec3_q1" value="1">
                2<input type="radio" name="sec3_q1" value="2">
                3<input type="radio" name="sec3_q1" value="3">
                4<input type="radio" name="sec3_q1" value="4">
                5<input type="radio" name="sec3_q1" value="5">}<br>
                <label>2-كانت ملاحظاته موضوعية ونزيهة.</label><br>
                {1<input type="radio" name="sec3_q2" value="1">
                2<input type="radio" name="sec3_q2" value="2">
                3<input type="radio" name="sec3_q2" value="3">
                4<input type="radio" name="sec3_q2" value="4">
                5<input type="radio" name="sec3_q2" value="5">}<br>
                <label>3-قدم بالدعم والمساندة باستمرار.</label><br>
                {1<input type="radio" name="sec3_q3" value="1">
                2<input type="radio" name="sec3_q3" value="2">
                3<input type="radio" name="sec3_q3" value="3">
                4<input type="radio" name="sec3_q3" value="4">
                5<input type="radio" name="sec3_q3" value="5">}<br>
                <label>4-كانت اجتماعاتنا معه بناءة ومثمرة.</label><br>
                {1<input type="radio" name="sec3_q4" value="1">
                2<input type="radio" name="sec3_q4" value="2">
                3<input type="radio" name="sec3_q4" value="3">
                4<input type="radio" name="sec3_q4" value="4">
                5<input type="radio" name="sec3_q4" value="5">}<br>
                <label>5-كانت تعليقاته على ملف الانجاز ومذكراتي مفيدة وفاعلة.</label><br>
                {1<input type="radio" name="sec3_q5" value="1">
                2<input type="radio" name="sec3_q5" value="2">
                3<input type="radio" name="sec3_q5" value="3">
                4<input type="radio" name="sec3_q5" value="4">
                5<input type="radio" name="sec3_q5" value="5">}<br>
                <label>6-قام بالتعريف بامكانات المدرسة المادية التي يمكن الاستفادة منها.</label><br>
                {1<input type="radio" name="sec3_q6" value="1">
                2<input type="radio" name="sec3_q6" value="2">
                3<input type="radio" name="sec3_q6" value="3">
                4<input type="radio" name="sec3_q6" value="4">
                5<input type="radio" name="sec3_q6" value="5">}<br>
                <label>7-ذلل سبل المشاركة في الأنشطة المدرسية المختلفة.</label><br>
                {1<input type="radio" name="sec3_q7" value="1">
                2<input type="radio" name="sec3_q7" value="2">
                3<input type="radio" name="sec3_q7" value="3">
                4<input type="radio" name="sec3_q7" value="4">
                5<input type="radio" name="sec3_q7" value="5">}<br>
                <label>8-قام بشرح العمليات الادارية في المدرسة وأتاح فرصة للتعرف عليها.</label><br>
                {1<input type="radio" name="sec3_q8" value="1">
                2<input type="radio" name="sec3_q8" value="2">
                3<input type="radio" name="sec3_q8" value="3">
                4<input type="radio" name="sec3_q8" value="4">
                5<input type="radio" name="sec3_q8" value="5">}<br>
                <label>9-أداؤه المهني عال ونزيه.</label><br>
                {1<input type="radio" name="sec3_q9" value="1">
                2<input type="radio" name="sec3_q9" value="2">
                3<input type="radio" name="sec3_q9" value="3">
                4<input type="radio" name="sec3_q9" value="4">
                5<input type="radio" name="sec3_q9" value="5">}<br>
            </div><br>
            <button type="submit" id="button">أرسال</button>
        </form>
    </div>
</body>

</html>
<?php
    }else{
        header("location:home.php");
    }
}
else{
    header("location:home.php");
}