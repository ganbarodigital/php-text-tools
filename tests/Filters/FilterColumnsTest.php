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
 * @coversDefaultClass GanbaroDigital\TextTools\Filters\FilterColumns
 */
class FilterColumnsTest extends PHPUnit_Framework_TestCase
{
    /**
     * @coversNothing
     */
    public function testCanInstantiate()
    {
        // ----------------------------------------------------------------
        // setup your test

        $obj = new FilterColumns;

        // ----------------------------------------------------------------
        // test the results

        $this->assertTrue($obj instanceof FilterColumns);
    }

    /**
     * @covers ::__invoke
     * @dataProvider provideDataToFilter
     */
    public function testCanUseAsObject($data, $columnNos, $expectedResult)
    {
        // ----------------------------------------------------------------
        // setup your test

        $obj = new FilterColumns;

        // ----------------------------------------------------------------
        // perform the change

        $actualResult = $obj($data, $columnNos, ' ', PHP_EOL);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedResult, $actualResult);
    }

    /**
     * @covers ::from
     * @dataProvider provideDataToFilter
     */
    public function testCanCallStatically($data, $columnNos, $expectedResult)
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        $actualResult = FilterColumns::from($data, $columnNos, ' ', PHP_EOL);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedResult, $actualResult);
    }

    /**
     * @covers ::fromTraversable
     * @covers ::filterArray
     * @dataProvider provideArraysToFilter
     */
    public function testCanStaticallyFilterArrays($data, $columnNos, $expectedResult)
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        $actualResult = FilterColumns::fromTraversable($data, $columnNos, ' ', PHP_EOL);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedResult, $actualResult);
    }

    /**
     * @covers ::fromString
     * @covers ::filterLine
     * @dataProvider provideStringsToFilter
     */
    public function testCanStaticallyFilterStrings($data, $columnNos, $expectedResult)
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        $actualResult = FilterColumns::fromString($data, $columnNos, ' ', PHP_EOL);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedResult, $actualResult);
    }

    public function provideDataToFilter()
    {
        return array_merge($this->provideStringsToFilter(), $this->provideArraysToFilter());
    }

    public function provideArraysToFilter()
    {
        return [
            [
                [
                    "  502 42544     1   0  5:37pm ??         0:00.02 /System/Library/CoreServices/AirPort Base Station Agent.app/Contents/MacOS/AirPort Base Station Agent --launchd",
                    "    0 42759     1   0  6:36pm ??         0:00.26 /usr/sbin/ocspd",
                    "  502 42790     1   0  6:41pm ??         0:00.35 /System/Library/Frameworks/CoreServices.framework/Frameworks/Metadata.framework/Versions/A/Support/mdworker -s mdworker -c MDSImporterWorker -m com.apple.mdworker.shared",
                ],
                "7-20",
                [
                    "/System/Library/CoreServices/AirPort Base Station Agent.app/Contents/MacOS/AirPort Base Station Agent --launchd",
                    "/usr/sbin/ocspd",
                    "/System/Library/Frameworks/CoreServices.framework/Frameworks/Metadata.framework/Versions/A/Support/mdworker -s mdworker -c MDSImporterWorker -m com.apple.mdworker.shared",
                ]
            ],
        ];
    }

    public function provideStringsToFilter()
    {
        return [
            [
                "  501 42435 38008   0  9:33AM ??         0:00.13 php vendor/bin/phpunit -c phpunit.xml.dist FilterColumnsTest tests/Filters/FilterColumnsTest.php",
                "7-100",
                "php vendor/bin/phpunit -c phpunit.xml.dist FilterColumnsTest tests/Filters/FilterColumnsTest.php"
            ],
            [
                "  501 42435 38008   0  9:33AM ??         0:00.13 php vendor/bin/phpunit -c phpunit.xml.dist FilterColumnsTest tests/Filters/FilterColumnsTest.php",
                "0",
                "501"
            ]
        ];
    }
}