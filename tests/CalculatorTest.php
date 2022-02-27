<?php

declare(strict_types=1);

namespace Deg540\PHPTestingBoilerplate\Test;

use Deg540\PHPTestingBoilerplate\Calculator;
use PHPUnit\Framework\TestCase;

final class CalculatorTest extends TestCase {
    /**
     * @test
     */
    public function emptyStringAddsZero() {
        $calculator = new Calculator();

        $result = $calculator->add("");

        $this->assertEquals("0", $result);
    }

    /**
     * @test
     */
    public function oneElementStringAddsHimself() {
        $calculator = new Calculator();

        $result = $calculator->add("1.3");

        $this->assertEquals("1.3", $result);
    }

    /**
     * @test
     */
    public function twoElementsStringAddsBoth() {
        $calculator = new Calculator();

        $result = $calculator->add("1.1,2.2");

        $this->assertEquals("3.3", $result);
    }

    /**
     * @test
     */
    public function unknownNumberOfElementsStringAddsAll() {
        $calculator = new Calculator();

        $result = $calculator->add("1.1,2.2,3.3,1,0,0.3");

        $this->assertEquals("7.9", $result);
    }

    /**
     * @test
     */
    public function allowNewlineAsSeparatorAtAdd() {
        $calculator = new Calculator();

        $result = $calculator->add("1\n2,3");

        $this->assertEquals("6", $result);
    }

    /**
     * @test
     */
    public function CheckSeparatorAtAdd() {
        $calculator = new Calculator();

        $result = $calculator->add("175.2,\n35");

        $this->assertEquals("Number expected but '\n' found at position 6.", $result);
    }

    /**
     * @test
     */
    public function MissingLastNumberAtAdd() {
        $calculator = new Calculator();

        $result = $calculator->add("1,3,");

        $this->assertEquals("Number expected but NOT found.", $result);
    }

    /**
     * @test
     */
    public function CustomDelimiterAtAdd() {
        $calculator = new Calculator();

        $result1 = $calculator->add("//;\n1;2");

        $this->assertEquals("3", $result1);

        $result2 = $calculator->add("//|\n1|2|3");

        $this->assertEquals("6", $result2);

        $result3 = $calculator->add("//sep\n2sep3");

        $this->assertEquals("5", $result3);

        $result4 = $calculator->add("//|\n1|2,3");

        $this->assertEquals("'|' expected but ',' found at position 3.", $result4);
    }

    /**
     * @test
     */
    public function NegativeNumbersAdd() {
        $calculator = new Calculator();

        $result = $calculator->add("-1,2");

        $this->assertEquals("Negative not allowed: -1", $result);

        $result = $calculator->add("2,-4,-5");

        $this->assertEquals("Negative not allowed: -4, -5", $result);
    }

    /**
     * @test
     */
    public function MultipleErrorsAdd() {
        $calculator = new Calculator();

        $result = $calculator->add("-1,,2");

        $this->assertEquals("Number expected but ',' found at position 3.\nNegative not allowed: -1", $result);
    }

    /**
     * @test
     */
    public function shouldMultiplyTwoArguments() {
        $calculator = new Calculator();

        $result = $calculator->multiply(1, 2);

        $this->assertEquals(2, $result);
    }
}
