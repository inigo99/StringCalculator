<?php

namespace Deg540\PHPTestingBoilerplate;

class Calculator{

    function add(String $numbers): String{
        $length = strlen($numbers);

        // If length is 0, empty string
        if($length == 0){
            return "0";
        }else{
            $pos = strpos($numbers, ",");
            if($pos === false) {
                // If no comma, one element
                return $numbers;
            }
        }
        return "";
    }

    function multiply(int $number1, int $number2): int
    {
        return 0;
    }
}