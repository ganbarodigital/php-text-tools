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
 * @package   TextTools/ValueBuilders
 * @author    Stuart Herbert <stuherbert@ganbarodigital.com>
 * @copyright 2015-present Ganbaro Digital Ltd www.ganbarodigital.com
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link      http://code.ganbarodigital.com/php-text-tools
 */

namespace GanbaroDigital\TextTools\ValueBuilders;

use PHPUnit_Framework_TestCase;

/**
 * @coversDefaultClass GanbaroDigital\TextTools\ValueBuilders\ExpandRange
 */
class ExpandRangeTest extends PHPUnit_Framework_TestCase
{
    /**
     * @coversNothing
     */
    public function testCanInstantiate()
    {
        // ----------------------------------------------------------------
        // setup your test

        $obj = new ExpandRange;

        // ----------------------------------------------------------------
        // test the results

        $this->assertTrue($obj instanceof ExpandRange);
    }

    /**
     * @covers ::__invoke
     * @dataProvider provideRangesToExpand
     */
    public function testCanUseAsObject($range, $expectedResult)
    {
        // ----------------------------------------------------------------
        // setup your test

        $obj = new ExpandRange;

        // ----------------------------------------------------------------
        // perform the change

        $actualResult = $obj($range);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedResult, $actualResult);
    }

    /**
     * @covers ::from
     * @dataProvider provideRangesToExpand
     */
    public function testCanCallStatically($range, $expectedResult)
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        $actualResult = ExpandRange::from($range);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedResult, $actualResult);
    }

    /**
     * @covers ::fromTraversable
     * @covers ::fromString
     * @covers ::parseString
     * @covers ::parseRange
     * @dataProvider provideArrayRangesToExpand
     */
    public function testStaticallyExpandArrays($range, $expectedResult)
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        $actualResult = ExpandRange::fromTraversable($range);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedResult, $actualResult);
    }

    /**
     * @covers ::fromString
     * @covers ::parseString
     * @covers ::parseRange
     * @dataProvider provideStringRangesToExpand
     */
    public function testStaticallyExpandStrings($range, $expectedResult)
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        $actualResult = ExpandRange::fromString($range);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedResult, $actualResult);
    }

    /**
     * @covers ::fromString
     * @covers ::parseString
     * @covers ::parseRange
     */
    public function testPreservesRangesInReverseOrder()
    {
        // ----------------------------------------------------------------
        // setup your test

        $range = "12-6";
        $expectedResult = range(12, 6);

        // ----------------------------------------------------------------
        // perform the change

        $actualResult = ExpandRange::fromString($range);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedResult, $actualResult);
    }

    /**
     * @covers ::fromString
     * @covers ::parseString
     * @covers ::parseRange
     * @dataProvider provideIllegalRangeStrings
     *
     * @expectedException GanbaroDigital\TextTools\Exceptions\E4xx_CannotParseRange
     */
    public function testThrowsExceptionWhenIllegalRangeReceived($range)
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        ExpandRange::fromString($range);

    }

    public function provideRangesToExpand()
    {
        return array_merge(
            $this->provideStringRangesToExpand(),
            $this->provideArrayRangesToExpand()
        );
    }

    public function provideArrayRangesToExpand()
    {
        return [
            [
                [ "1-50", "2-5", "11-12" ],
                [ range(1, 50), range(2,5), range(11,12) ]
            ]
        ];
    }

    public function provideStringRangesToExpand()
    {
        return [
            [ "0-9", [0, 1, 2, 3, 4, 5, 6, 7, 8, 9] ],
            [ "4-7", [4, 5, 6, 7 ] ],
            [ "8-100", range(8, 100) ],
            [ "3, 6-8, 10", [3, 6, 7, 8, 10] ],
        ];
    }

    public function provideIllegalRangeStrings()
    {
        return [
            [ "1-" ],
            [ "a-b" ]
        ];
    }
}