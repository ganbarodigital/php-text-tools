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
 * @package   TextTools/Filters
 * @author    Stuart Herbert <stuherbert@ganbarodigital.com>
 * @copyright 2015-present Ganbaro Digital Ltd www.ganbarodigital.com
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link      http://code.ganbarodigital.com/php-text-tools
 */

namespace GanbaroDigital\TextTools\Filters;

use PHPUnit_Framework_TestCase;

/**
 * @coversDefaultClass GanbaroDigital\TextTools\Filters\FilterOutEmptyValues
 */
class FilterOutEmptyValuesTest extends PHPUnit_Framework_TestCase
{
    /**
     * @coversNothing
     */
    public function testCanInstantiate()
    {
        // ----------------------------------------------------------------
        // setup your test

        $obj = new FilterOutEmptyValues;

        // ----------------------------------------------------------------
        // test the results

        $this->assertTrue($obj instanceof FilterOutEmptyValues);
    }

    /**
     * @covers ::__invoke
     * @dataProvider provideDataToFilter
     */
    public function testCanUseAsObject($input, $expectedResult)
    {
        // ----------------------------------------------------------------
        // setup your test

        $obj = new FilterOutEmptyValues;

        // ----------------------------------------------------------------
        // perform the change

        $actualResult = $obj($input);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedResult, $actualResult);
    }

    /**
     * @covers ::from
     * @dataProvider provideDataToFilter
     */
    public function testCanCallStatically($input, $expectedResult)
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        $actualResult = FilterOutEmptyValues::from($input);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedResult, $actualResult);
    }

    /**
     * @covers ::fromTraversable
     * @covers ::fromString
     * @covers ::fromNull
     * @dataProvider provideArraysToFilter
     */
    public function testCanStaticallyFilterArrays($input, $expectedResult)
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        $actualResult = FilterOutEmptyValues::from($input);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedResult, $actualResult);
    }

    /**
     * @covers ::fromString
     * @dataProvider provideStringsToFilter
     */
    public function testCanStaticallyFilterStrings($input, $expectedResult)
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        $actualResult = FilterOutEmptyValues::from($input);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedResult, $actualResult);
    }

    /**
     * @covers ::fromCallable
     * @dataProvider provideCallablesToFilter
     */
    public function testCanStaticallyFilterCallables($input, $expectedResult)
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        $actualResult = FilterOutEmptyValues::from($input);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedResult, $actualResult);
    }

    /**
     * @covers ::nothingMatchesTheInputType
     * @dataProvider provideBadData
     *
     * @expectedException GanbaroDigital\TextTools\Exceptions\E4xx_UnsupportedType
     */
    public function testRejectsOtherDataTypes($input)
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        FilterOutEmptyValues::from($input);
    }

    public function provideDataToFilter()
    {
        return array_merge(
            $this->provideStringsToFilter(),
            $this->provideArraysToFilter(),
            $this->provideCallablesToFilter()
        );
    }

    public function provideArraysToFilter()
    {
        return [
            [
                [
                    "100",
                    "",
                    "hello, world",
                ],
                [
                    "100",
                    "hello, world",
                ],
            ],
            [
                [
                    null,
                    "hello, world",
                ],
                [
                    "hello, world",
                ]
            ]
        ];
    }

    public function provideCallablesToFilter()
    {
        return [
            [
                function() { return "hello, world"; }, "hello, world",
            ],
            [
                function() { return ""; }, null,
            ],
            [
                function() { return [ "hello, world", "", "100" ]; },
                [ "hello, world", "100" ],
            ],
        ];
    }

    public function provideStringsToFilter()
    {
        return [
            [ "hello, world", "hello, world" ],
            [ "0", "0" ],
            [ "100", "100" ],
            [ "", null ],
            [ '', null ],
            [ " ", null ],
            [ "\t", null ],
            [ "\r" , null ],
            [ "\n", null ],
        ];
    }

    public function provideBadData()
    {
        return [
            [ true ],
            [ false ],
            [ 3.1415927 ],
            [ 0 ],
            [ 100 ],
            [ STDIN ],
        ];
    }
}