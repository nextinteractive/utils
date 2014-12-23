<?php
/*
 * Copyright (c) 2011-2014 Lp digital system
 *
 * This file is part of BackBee.
 *
 * BackBee5 is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * BackBee is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with BackBee. If not, see <http://www.gnu.org/licenses/>.
 */
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
