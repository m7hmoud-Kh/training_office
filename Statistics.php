<?php
session_start();
if(isset($_SESSION['user_name'])){
require 'db.php';
require 'helper.php';

$stmt = $con->prepare('SELECT school_id , schools.name FROM polls JOIN schools ON polls.school_id = schools.id GROUP BY polls.school_id; ');
$stmt->execute();
$schools = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link href="css/Statistics.css" rel="stylesheet">
    <link href="css/header.css" rel="stylesheet" />

    <title>Statistics</title>
</head>

<body dir="rtl">
<?php
  require 'header_admin.php';
  ?>
    <main>
        <table id="tbl">
            <tr>
                <th>م</th>
                <th>اسم المدرسه</th>
                <th>عدد الطلاب</th>
                <th>نسبه التقيم في رأي الطلاب في أداء المشرف التربوي</th>
                <th>نسبه التقيم في رأي الطلاب في أداء المشرف الأكاديمي</th>
                <th>نسبه التقيم في رأي الطلاب في أداء مدير المدرسة</th>
            </tr>

            <?php
            $m = 1;
            foreach ($schools as $school) {

                $section_1 = get_all_answer_per_section(1,$school['school_id']);
                $section_2 = get_all_answer_per_section(2,$school['school_id']);
                $section_3 = get_all_answer_per_section(3,$school['school_id']);

                ?>
                <tr>
                    <td><?=$m?></td>
                    <td><?=$school['name']?></td>
                    <td><?= $section_1[0] ?></td>
                    <td><?= $section_1[1] ?></td>
                    <td><?= $section_2[1] ?></td>
                    <td><?= $section_3[1] ?></td>
                </tr>
                <?php
                $m++;
            }

            ?>
        </table>
    </main>
</body>

</html>
<?php
}
else{
    header("location:login.php");
}