<?php

namespace Deg540\PHPTestingBoilerplate;

class Calculator{

    function add(String $numbers): String {
        $length = strlen($numbers);

        // If length is 0, empty string
        if ($length == 0) {
            return "0";
        } else {
            $number1 = strtok($numbers, ',');
            $number2 = strtok('/');
            // Add first element to result
            $result = floatval($number1);
            while ($number2 !== false) {
                // If enters here, more than one element
                $number1 = strtok($number2, ',');
                $number2 = strtok('/');
                $result = $result + floatval($number1);
            }

            // Return as String
            return strval($result);
        }
    }

    function multiply(int $number1, int $number2): int
    {
        return 0;
    }
}