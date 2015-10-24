<?php

/**
 * Copyright (c) 2015-present Ganbaro Digital Ltd
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *   * Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 *
 *   * Neither the names of the copyright holders nor the names of his
 *     contributors may be used to endorse or promote products derived
 *     from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @category  Libraries
 * @package   TextTools/Operators
 * @author    Stuart Herbert <stuherbert@ganbarodigital.com>
 * @copyright 2015-present Ganbaro Digital Ltd www.ganbarodigital.com
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link      http://code.ganbarodigital.com/php-text-tools
 */

namespace GanbaroDigital\TextTools\Operators;

use GanbaroDigital\NumberTools\Operators\CompareTwoNumbers;
use PHPUnit_Framework_TestCase;
use stdClass;

/**
 * @coversDefaultClass GanbaroDigital\TextTools\Operators\CompareTwoStrings
 */
class CompareTwoStringsTest extends PHPUnit_Framework_TestCase
{
    /**
     * @coversNothing
     */
    public function testCanInstantiate()
    {
        // ----------------------------------------------------------------
        // setup your test

        $obj = new CompareTwoStrings;

        // ----------------------------------------------------------------
        // test the results

        $this->assertTrue($obj instanceof CompareTwoStrings);
    }

    /**
     * @covers ::__invoke
     * @dataProvider provideDataToCompare
     */
    public function testCanUseAsObject($lhs, $rhs, $expectedResult)
    {
        // ----------------------------------------------------------------
        // setup your test

        $obj = new CompareTwoStrings;

        // ----------------------------------------------------------------
        // perform the change

        $actualResult = $obj($lhs, $rhs);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedResult, $actualResult);
    }

    /**
     * @covers ::calculate
     * @dataProvider provideDataToCompare
     */
    public function testCanCallStatically($lhs, $rhs, $expectedResult)
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        $actualResult = CompareTwoStrings::calculate($lhs, $rhs);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedResult, $actualResult);
    }

    /**
     * @covers ::calculate
     * @dataProvider provideNonStrings
     * @expectedException GanbaroDigital\TextTools\Exceptions\E4xx_UnsupportedType
     */
    public function testRejectsNonStrings($lhs, $rhs)
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        CompareTwoStrings::calculate($lhs, $rhs);
    }

    public function provideDataToCompare()
    {
        return [
            [ 'a', 'b', CompareTwoNumbers::A_IS_LESS ],
            [ 'b', 'a', CompareTwoNumbers::A_IS_GREATER ],
            [ 'b', 'b', CompareTwoNumbers::BOTH_ARE_EQUAL ],
        ];
    }

    public function provideNonStrings()
    {
        return [
            [ null, 'a string' ],
            [ [], 'a string' ],
            [ true, 'a string' ],
            [ false, 'a string' ],
            [ function() { return 'a string'; }, 'a string' ],
            [ 3.1415927, 'a string' ],
            [ 0, 'a string' ],
            [ 100, 'a string' ],
            [ new stdClass, 'a string' ],
            [ STDIN, 'a string' ],
            [ 'a string', null ],
            [ 'a string', [] ],
            [ 'a string', true ],
            [ 'a string', false ],
            [ 'a string', function() { return 'a string'; } ],
            [ 'a string', 3.1415927 ],
            [ 'a string', 0 ],
            [ 'a string', 100 ],
            [ 'a string', new stdClass ],
            [ 'a string', STDIN ],
        ];
    }
}