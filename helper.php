<?php

require 'db.php';

function validate_empty_input($input){

    if(empty($input)){
        return $input . " must not be Empty";
    }

}


function get_gender($gender){
    if($gender == 1){
        return 'انثي';
    }elseif($gender != null){
        return  'ذكر';
    }else{
        return 'مشتركه';
    }
}



function get_all_answer_per_section($section_id,$school_id){
    global $con;
    $stmt = $con->prepare('SELECT SUM(answer) AS sum_per_section , COUNT(DISTINCT(student_id)) AS count_student FROM polls JOIN schools ON polls.school_id = schools.id WHERE section_id = ? AND school_id = ? GROUP BY school_id; ');
    $stmt->execute(array($section_id,$school_id));
    $result = $stmt->fetch();
    $percent = make_percent_by_section($result['sum_per_section'],$result['count_student']);

    return array($result['count_student'] , $percent);
}

function make_percent_by_section($sum_per_section,$count_student){
    return  number_format(($sum_per_section / ($count_student * 45)) * 100,2) . '%' ;
}