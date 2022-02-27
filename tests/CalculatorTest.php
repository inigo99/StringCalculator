<?php

declare(strict_types=1);

namespace Deg540\PHPTestingBoilerplate\Test;

use Deg540\PHPTestingBoilerplate\Calculator;
use PHPUnit\Framework\TestCase;

final class CalculatorTest extends TestCase
{
    /**
     * @test
     */
    public function emptyStringAddsZero()
    {
        $calculator = new Calculator();

        $result = $calculator->add("");

        $this->assertEquals("0", $result);
    }

    /**
     * @test
     */
    public function shouldMultiplyTwoArguments()
    {
        $calculator = new Calculator();

        $result = $calculator->multiply(1, 2);

        $this->assertEquals(2, $result);
    }
}
