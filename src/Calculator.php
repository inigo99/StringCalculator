<?php

namespace Deg540\PHPTestingBoilerplate;

class Calculator{

    function add(String $numbers): String {
        $length = strlen($numbers);

        // If length is 0, empty string
        if ($length == 0) {
            return "0";
        } else {
            $error = $this->checkInput($numbers);
            if (strcmp($error, "") !== 0) {
                // If there's an error, return error message
                return $error;
            }

            $number1 = strtok($numbers, $this->separator($numbers));
            $number2 = strtok('/');
            // Add first element to result
            $result = floatval($number1);
            while ($number2 !== false) {
                // If enters here, more than one element
                $number1 = strtok($number2, $this->separator($number2));
                $number2 = strtok('/');
                $result = $result + floatval($number1);
            }

            // Return as String
            return strval($result);
        }
    }

    function separator(String $string): String{
        // Search for position of the nearest comma and newline
        $comma = strpos($string, ",");
        $newLine = strpos($string, "\n");

        if ($comma !== false) {
            // If there's a comma
            if ($newLine !== false) {
                // If there's a newLine
                if ($comma < $newLine) {
                    // If there's a comma first
                    return ",";
                } else {
                    // If there's a newLine first
                    return "\n";
                }
            } else {
                // If there's only a comma
                return ",";
            }
        } else if ($newLine !== false) {
            // If there's only a newline
            return "\n";
        }
        return "";
    }

    function checkInput(String $input) {
        $pos1 = strpos($input, ",\n");
        $pos2 = strpos($input, "\n,");
        if ($pos1 !== false) {
            // If there's an newline after a comma
            if ($pos2 !== false) {
                // If there's a comma after a newline
                if ($pos1 < $pos2) {
                    // If the comma comes first
                    $val = "\n";
                    $pos = $pos1 + 1;
                } else {
                    // If the newline comes first
                    $val = ",";
                    $pos = $pos2 + 1;
                }
            } else {
                // Only newline after comma
                $val = "\n";
                $pos = $pos1 + 1;
            }
        } else if ($pos2 !== false) {
            // If there's a comma after a newline
            $val = ",";
            $pos = $pos2 + 1;
        } else {
            return "";
        }
        return "Number expected but '" . $val . "' found at position " . $pos .".";
    }

    function multiply(int $number1, int $number2): int
    {
        return 0;
    }
}