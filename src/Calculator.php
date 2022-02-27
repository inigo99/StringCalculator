<?php

namespace Deg540\PHPTestingBoilerplate;

use http\Encoding\Stream;

class Calculator{

    function add(String $numbers): String {
        $length = strlen($numbers);

        // If length is 0, empty string
        if ($length == 0) {
            return "0";
        } else {
            // Get the custom delimiter
            $delimiter = $this->getCustomDelimiter($numbers);

            if ($numbers[0] === '/'){
                // If using a custom delimiter, cut the input string
                $cutPos = strlen("//".$delimiter."\n");
                $numbers = substr($numbers, $cutPos);
            }

            $error = $this->checkInput($numbers, $delimiter);
            if (strcmp($error, "") !== 0) {
                // If there's an error, return error message
                return $error;
            }

            $number1 = strtok($numbers, $this->separator($numbers, $delimiter));
            $number2 = strtok('/');
            // Add first element to result
            $result = floatval($number1);
            while ($number2 !== false) {
                // If enters here, more than one element
                $number1 = strtok($number2, $this->separator($number2, $delimiter));
                $number2 = strtok('/');
                $result = $result + floatval($number1);
            }

            // Return as String
            return strval($result);
        }
    }

    function separator(String $input, String $delimiter): String {
        // Search for position of the nearest delimiter and newline
        $comma = stripos($input, $delimiter);
        $newLine = stripos($input, "\n");

        if ($comma !== false) {
            // If there's a delimiter
            if ($newLine !== false) {
                // If there's a newLine
                if ($comma < $newLine) {
                    // If there's a delimiter first
                    return $delimiter;
                } else {
                    // If there's a newLine first
                    return "\n";
                }
            } else {
                // If there's only a delimiter
                return $delimiter;
            }
        } else if ($newLine !== false) {
            // If there's only a newline
            return "\n";
        }
        return "";
    }

    function checkInput(String $input, String $delimiter): String {
        $pos1 = stripos($input, $delimiter."\n");
        $pos2 = stripos($input, "\n".$delimiter);
        if ($pos1 !== false) {
            // If there's an newline after a delimiter
            if ($pos2 !== false) {
                // If there's a delimiter after a newline
                if ($pos1 < $pos2) {
                    // If the delimiter comes first
                    $val = "\n";
                    $pos = $pos1 + 1;
                } else {
                    // If the newline comes first
                    $val = $delimiter;
                    $pos = $pos2 + 1;
                }
            } else {
                // Only newline after delimiter
                $val = "\n";
                $pos = $pos1 + 1;
            }
        } else if ($pos2 !== false) {
            // If there's a delimiter after a newline
            $val = $delimiter;
            $pos = $pos2 + 1;
        } else {
            // Check if the last number is missing
            $lastChar = substr($input, -1);
            if (strcmp($lastChar, $delimiter) === 0) {
                return "Number expected but NOT found.";
            } else{
                return "";
            }
        }
        return "Number expected but '" . $val . "' found at position " . $pos .".";
    }

    function getCustomDelimiter(String $input): String {
        $start = substr($input, 0, 2);
        if (strcmp($start, "//") === 0) {
            // If starts with "//" there's a custom delimiter
            $end = stripos($input, "\n");;
            $delimiter = substr($input, 2, $end - 2);
            return $delimiter;
        } else {
            return ",";
        }
    }

    function multiply(int $number1, int $number2): int
    {
        return 0;
    }
}