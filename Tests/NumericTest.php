<?php

namespace BackBee\Utils\Tests;

use BackBee\Utils\Numeric;

class NumericTest extends \PHPUnit_Framework_TestCase
{
    public function testIsInteger()
    {
        $num = new Numeric();

        $var = 11;
        $res = $num->isInteger($var);
        $this->assertEquals(true, $res);

        $var1 = -11;
        $res1 = $num->isInteger($var1);
        $this->assertEquals(true, $res1);

        $var2 = 11.35;
        $res2 = $num->isInteger($var2);
        $this->assertEquals(false, $res2);
    }

    public function testIsPositiveInteger()
    {
        $num = new Numeric();

        $var = 11;
        $res = $num->isPositiveInteger($var);
        $this->assertEquals(true, $res);

        $var2 = 11.35;
        $res2 = $num->isPositiveInteger($var2);
        $this->assertEquals(false, $res2);

        $var = -11;
        $res = $num->isPositiveInteger($var);
        $this->assertEquals(false, $res);
    }
}
