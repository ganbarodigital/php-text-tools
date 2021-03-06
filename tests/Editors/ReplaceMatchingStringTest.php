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
 * @coversDefaultClass GanbaroDigital\TextTools\Editors\ReplaceMatchingString
 */
class ReplaceMatchingStringTest extends PHPUnit_Framework_TestCase
{
    /**
     * @coversNothing
     */
    public function testCanInstantiate()
    {
        // ----------------------------------------------------------------
        // setup your test

        $obj = new ReplaceMatchingString;

        // ----------------------------------------------------------------
        // test the results

        $this->assertTrue($obj instanceof ReplaceMatchingString);
    }

    /**
     * @covers ::__invoke
     * @dataProvider provideDataToEdit
     */
    public function testCanUseAsObject($data, $match, $replacement, $expectedResult)
    {
        // ----------------------------------------------------------------
        // setup your test

        $obj = new ReplaceMatchingString;

        // ----------------------------------------------------------------
        // perform the change

        $actualResult = $obj($data, $match, $replacement);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedResult, $actualResult);
    }

    /**
     * @covers ::in
     * @dataProvider provideDataToEdit
     */
    public function testCanCallStatically($data, $match, $replacement, $expectedResult)
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        $actualResult = ReplaceMatchingString::in($data, $match, $replacement);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedResult, $actualResult);
    }

    /**
     * @covers ::inArray
     * @dataProvider provideArraysToEdit
     */
    public function testCanProcessArrays($data, $match, $replacement, $expectedResult)
    {
        // ----------------------------------------------------------------
        // setup your test

        $obj = new ReplaceMatchingString;

        // ----------------------------------------------------------------
        // perform the change

        $actualResult1 = $obj($data, $match, $replacement);
        $actualResult2 = ReplaceMatchingString::in($data, $match, $replacement);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedResult, $actualResult1);
        $this->assertEquals($expectedResult, $actualResult2);
    }

    /**
     * @covers ::inString
     * @dataProvider provideStringsToEdit
     */
    public function testCanProcessStrings($data, $match, $replacement, $expectedResult)
    {
        // ----------------------------------------------------------------
        // setup your test

        $obj = new ReplaceMatchingString;

        // ----------------------------------------------------------------
        // perform the change

        $actualResult1 = $obj($data, $match, $replacement);
        $actualResult2 = ReplaceMatchingString::in($data, $match, $replacement);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedResult, $actualResult1);
        $this->assertEquals($expectedResult, $actualResult2);
    }

    /**
     * @covers ::inArray
     * @dataProvider provideTraversablesToEdit
     */
    public function testCanProcessTraversables($data, $match, $replacement, $expectedResult)
    {
        // ----------------------------------------------------------------
        // setup your test

        $obj = new ReplaceMatchingString;

        // ----------------------------------------------------------------
        // perform the change

        $actualResult1 = $obj($data, $match, $replacement);
        $actualResult2 = ReplaceMatchingString::in($data, $match, $replacement);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedResult, $actualResult1);
        $this->assertEquals($expectedResult, $actualResult2);
    }

    /**
     * @covers ::nothingMatchesTheInputType
     * @dataProvider provideEverythingElseToEdit
     * @expectedException GanbaroDigital\TextTools\Exceptions\E4xx_UnsupportedType
     */
    public function testRejectsEverythingElse($data)
    {
        // ----------------------------------------------------------------
        // setup your test

        $obj = new ReplaceMatchingString;
        $match = "abc";
        $replacement = "def";

        // ----------------------------------------------------------------
        // perform the change

        $obj($data, $match, $replacement);
    }

    public function provideDataToEdit()
    {
        return array_merge(
            $this->provideStringsToEdit(),
            $this->provideArraysToEdit(),
            $this->provideTraversablesToEdit()
        );
    }

    public function provideArraysToEdit()
    {
        return [
            [
                [
                    "* develop",
                    "  master ",
                    "  feature/trim-whitespace",
                ],
                "* ",
                "",
                [
                    "develop",
                    "  master ",
                    "  feature/trim-whitespace",
                ]
            ],
        ];
    }

    public function provideStringsToEdit()
    {
        return [
            [ "* master", "* ", "", "master" ],
        ];
    }

    public function provideTraversablesToEdit()
    {
        return [
            [ (object) [
                    "* develop",
                    "  master ",
                    "  feature/trim-whitespace",
                ],
                "* ",
                "",
                [
                    "develop",
                    "  master ",
                    "  feature/trim-whitespace",
                ]
            ]
        ];
    }

    public function provideEverythingElseToEdit()
    {
        return [
            [ null ],
            [ true ],
            [ false ],
            [ function() {} ],
            [ 3.1415927 ],
            [ 0 ],
            [ 100 ],
            [ new ReplaceMatchingString ],
            [ STDIN ],
        ];
    }
}