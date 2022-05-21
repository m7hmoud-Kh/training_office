<?php

function validate_empty_input($input){

    if(empty($input)){
        return $input . " must not be Empty";
    }

}