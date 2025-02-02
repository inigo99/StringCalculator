<?php

namespace Deg540\PHPTestingBoilerplate;

use http\Encoding\Stream;

class Calculator {

    function add(String $numbers): String {
        $length = strlen($numbers);

        // List for negatives
        $negatives = array();

        // List for errors
        $errors = "";

        // If length is 0, empty string
        if ($length == 0) {
            return "0";
        } else {
            // Get the custom delimiter
            $delimiter = $this->getCustomDelimiter($numbers);

            if ($numbers[0] === '/') {
                // If using a custom delimiter, cut the input string
                $cutPos = strlen("//".$delimiter."\n");
                $numbers = substr($numbers, $cutPos);
            }

            $error = $this->checkInput($numbers, $delimiter);
            if (strcmp($error, "") !== 0) {
                // If there's an error, add error message
                $errors = $errors . $error . "\n";
            }

            // Check if there are illegal delimiters
            $error = $this->checkDelimiter($numbers, $delimiter);
            if (strcmp($error, "") !== 0) {
                $errors = $errors . $error . "\n";
            }

            $number1 = strtok($numbers, $this->separator($numbers, $delimiter));
            $number2 = strtok('/');
            // If the number is negative it's added to the list
            if (floatval($number1) < 0) {
                $negatives[] = $number1;
            }

            // Add first element to result
            $result = floatval($number1);
            while ($number2 !== false) {
                // If enters here, more than one element
                $number1 = strtok($number2, $this->separator($number2, $delimiter));
                $number2 = strtok('/');
                // If delimiter is larger than 1, cut the delimiter that remains
                $number1 = substr($number1, strlen($delimiter) - 1);
                // If the number is negative it's added to the list
                if (floatval($number1) < 0) {
                    $negatives[] = $number1;
                }
                $result = $result + floatval($number1);
            }

            if (sizeof($negatives) > 0) {
                $list = "";
                foreach ($negatives as $negative) {
                    $list = $list . $negative . ", ";
                }
                $list = substr($list, 0, strlen($list) - 2);
                $errors = $errors . "Negative not allowed: " . $list . "\n";
            }

            if (strcmp($errors, "") !== 0) {
                return substr($errors, 0, strlen($errors) - 1);
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
                    $pos = $pos1 + strlen($delimiter);
                } else {
                    // If the newline comes first
                    $val = $delimiter;
                    $pos = $pos2 + 1;
                }
            } else {
                // Only newline after delimiter
                $val = "\n";
                $pos = $pos1 + strlen($delimiter);;
            }
        } else if ($pos2 !== false) {
            // If there's a delimiter after a newline
            $val = $delimiter;
            $pos = $pos2 + 1;
        } else {
            $pos3 = stripos($input, $delimiter.$delimiter);
            if ($pos3 !== false) {
                // If there's two consecutive delimiters
                $val = $delimiter;
                $pos = $pos3 + strlen($delimiter);
                return "Number expected but '" . $val . "' found at position " . $pos .".";
            }
            // Check if the last number is missing
            $lastChar = substr($input, -1);
            if (strcmp($lastChar, $delimiter) === 0) {
                return "Number expected but NOT found.";
            } else {
                return "";
            }
        }
        return "Number expected but '" . $val . "' found at position " . $pos .".";
    }

    function getCustomDelimiter(String $input): String {
        $start = substr($input, 0, 2);
        if (strcmp($start, "//") === 0) {
            // If starts with "//" there's a custom delimiter
            $end = stripos($input, "\n");
            $delimiter = substr($input, 2, $end - 2);
            return $delimiter;
        } else {
            return ",";
        }
    }

    function checkDelimiter(String $input, String $delimiter): String {
        for ($pos = 0; $pos < strlen($input); $pos++) {
            $char = $input[$pos];
            if (!is_numeric($char)) {
                // If char is not a number
                if ((strcmp($char, "\n") !== 0) && ($char !== '.') && ($char !== '-')) {
                    // If char is not newline or a dot or a negative operator
                    $illegal = substr($input, $pos, strlen(($delimiter)));
                    if (strcmp($delimiter, $illegal) !== 0) {
                        // If char is not our delimiter
                        return "'" . $delimiter . "' expected but '" . $illegal . "' found at position " . $pos . ".";
                    }
                    $pos = $pos + strlen($delimiter) - 1;
                }
                $pos = $pos + 1;
            }
        }
        return "";
    }
}