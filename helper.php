<?php

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