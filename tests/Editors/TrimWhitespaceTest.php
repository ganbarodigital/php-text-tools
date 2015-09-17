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
 * @package   TextTools/Editors
 * @author    Stuart Herbert <stuherbert@ganbarodigital.com>
 * @copyright 2015-present Ganbaro Digital Ltd www.ganbarodigital.com
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link      http://code.ganbarodigital.com/php-text-tools
 */

namespace GanbaroDigital\TextTools\Editors;

use PHPUnit_Framework_TestCase;

/**
 * @coversDefaultClass GanbaroDigital\TextTools\Editors\TrimWhitespace
 */
class TrimWhitespaceTest extends PHPUnit_Framework_TestCase
{
    /**
     * @coversNothing
     */
    public function testCanInstantiate()
    {
        // ----------------------------------------------------------------
        // setup your test

        $obj = new TrimWhitespace;

        // ----------------------------------------------------------------
        // test the results

        $this->assertTrue($obj instanceof TrimWhitespace);
    }

    /**
     * @covers ::__invoke
     * @dataProvider provideDataToFilter
     */
    public function testCanUseAsObject($data, $expectedResult)
    {
        // ----------------------------------------------------------------
        // setup your test

        $obj = new TrimWhitespace;

        // ----------------------------------------------------------------
        // perform the change

        $actualResult = $obj($data);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedResult, $actualResult);
    }

    /**
     * @covers ::from
     * @dataProvider provideDataToFilter
     */
    public function testCanCallStatically($data, $expectedResult)
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        $actualResult = TrimWhitespace::from($data);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedResult, $actualResult);
    }

    /**
     * @covers ::fromArray
     * @dataProvider provideArraysToFilter
     */
    public function testCanTrimArraysOfStrings($data, $expectedResult)
    {
        // ----------------------------------------------------------------
        // setup your test

        $obj = new TrimWhitespace;

        // ----------------------------------------------------------------
        // perform the change

        $actualResult1 = $obj($data);
        $actualResult2 = TrimWhitespace::from($data);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedResult, $actualResult1);
        $this->assertEquals($expectedResult, $actualResult2);
    }

    /**
     * @covers ::fromString
     * @dataProvider provideStringsToFilter
     */
    public function testCanTrimStrings($data, $expectedResult)
    {
        // ----------------------------------------------------------------
        // setup your test

        $obj = new TrimWhitespace;

        // ----------------------------------------------------------------
        // perform the change

        $actualResult1 = $obj($data);
        $actualResult2 = TrimWhitespace::from($data);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedResult, $actualResult1);
        $this->assertEquals($expectedResult, $actualResult2);
    }

    /**
     * @covers ::fromArray
     * @dataProvider provideTraversablesToFilter
     */
    public function testCanTrimTraversables($data, $expectedResult)
    {
        // ----------------------------------------------------------------
        // setup your test

        $obj = new TrimWhitespace;

        // ----------------------------------------------------------------
        // perform the change

        $actualResult1 = $obj($data);
        $actualResult2 = TrimWhitespace::from($data);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedResult, $actualResult1);
        $this->assertEquals($expectedResult, $actualResult2);
    }


    /**
     * @covers ::nothingMatchesTheInputType
     * @dataProvider provideEverythingElseToTest
     * @expectedException GanbaroDigital\TextTools\Exceptions\E4xx_UnsupportedType
     */
    public function testRejectsEverythingElse($data)
    {
        // ----------------------------------------------------------------
        // setup your test

        $obj = new TrimWhitespace;

        // ----------------------------------------------------------------
        // perform the change

        $obj($data);

        // ----------------------------------------------------------------
        // test the results
        //
        // if we get here, then the test has failed
    }

    public function provideDataToFilter()
    {
        return array_merge(
            $this->provideStringsToFilter(),
            $this->provideArraysToFilter(),
            $this->provideTraversablesToFilter()
        );
    }

    public function provideArraysToFilter()
    {
        return [
            [
                [
                    "* develop",
                    "  master ",
                    "  feature/trim-whitespace",
                ],
                [
                    "* develop",
                    "master",
                    "feature/trim-whitespace",
                ]
            ],
        ];
    }

    public function provideStringsToFilter()
    {
        return [
            [ "  master", "master" ],
            [ "master  ", "master" ]
        ];
    }

    public function provideTraversablesToFilter()
    {
        return [
            [ (object) [
                    "* develop",
                    "  master ",
                    "  feature/trim-whitespace",
                ],
                [
                    "* develop",
                    "master",
                    "feature/trim-whitespace",
                ]
            ]
        ];
    }

    public function provideEverythingElseToTest()
    {
        return [
            [ null ],
            [ true ],
            [ false ],
            [ function() {} ],
            [ 3.1415927 ],
            [ 0 ],
            [ 100 ],
            [ new TrimWhitespace ],
            [ STDIN ],
        ];
    }
}