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

use GanbaroDigital\Reflection\Requirements\RequireNumeric;
use GanbaroDigital\Reflection\Requirements\RequireTraversable;
use GanbaroDigital\Reflection\Requirements\RequireStringy;
use GanbaroDigital\Reflection\ValueBuilders\FirstMethodMatchingType;
use GanbaroDigital\TextTools\Exceptions\E4xx_UnsupportedType;
use GanbaroDigital\TextTools\ValueBuilders\ExpandRange;

class FilterColumns
{
    /**
     * extract the columns from a string
     *
     * @param  string $data
     *         the data to be filtered
     * @param  string $columnNos
     *         the columns to be extracted
     * @param  string $columnSeparator
     *         the column delimiter
     * @return string
     *         the filtered string
     */
    public static function fromString($data, $columnNos, $columnSeparator)
    {
        // robustness!
        RequireStringy::checkMixed($data, E4xx_UnsupportedType::class);
        RequireStringy::checkMixed($columnNos, E4xx_UnsupportedType::class);
        RequireStringy::checkMixed($columnSeparator, E4xx_UnsupportedType::class);

        $colsToMatch = ExpandRange::from($columnNos);
        return self::filterLine($data, $columnSeparator, $colsToMatch);
    }

    /**
     * extract the columns from an array of strings
     *
     * @param  array|Traversable $data
     *         the data to be filtered
     * @param  string $columnNos
     *         the columns to be extracted
     * @param  string $columnSeparator
     *         the column delimiter
     * @return array
     *         a list of the filtered strings
     */
    public static function fromTraversable($data, $columnNos, $columnSeparator)
    {
        // robustness!
        RequireTraversable::checkMixed($data, E4xx_UnsupportedType::class);
        RequireStringy::checkMixed($columnNos, E4xx_UnsupportedType::class);
        RequireStringy::checkMixed($columnSeparator, E4xx_UnsupportedType::class);

        $colsToMatch = ExpandRange::from($columnNos);
        return self::filterArray($data, $columnSeparator, $colsToMatch);
    }

    /**
     * extract the columns from a string
     *
     * @param  string $data
     *         the data to be filtered
     * @param  string $columnNos
     *         the columns to be extracted
     * @param  string $columnSeparator
     *         the column delimiter
     * @return string
     *         the filtered string
     */
    public static function from($data, $columnNos, $columnSeparator)
    {
        $method = FirstMethodMatchingType::fromMixed($data, self::class, 'from', E4xx_UnsupportedType::class);
        return self::$method($data, $columnNos, $columnSeparator);
    }

    /**
     * extract the columns from a string
     *
     * @param  string $data
     *         the data to be filtered
     * @param  string $columnNos
     *         the columns to be extracted
     * @param  string $columnSeparator
     *         the column delimiter
     * @return string
     *         the filtered string
     */
    public function __invoke($data, $columnNos, $columnSeparator)
    {
        return self::from($data, $columnNos, $columnSeparator);
    }

    /**
     * filter an array of strings
     *
     * @param  array|Traversable $data
     *         the data to filter
     * @param  string $columnSeparator
     *         the column delimiter
     * @param  array $columnNos
     *         a list of the column numbers we are interested in
     * @return array
     *         the extracted columns
     */
    private static function filterArray($data, $columnSeparator, $columnNos)
    {
        $retval = [];

        foreach ($data as $line) {
            RequireStringy::checkMixed($line, E4xx_UnsupportedType::class);
            $retval[] = self::filterLine($line, $columnSeparator, $columnNos);
        }

        return $retval;
    }

    /**
     * filter an array of strings
     *
     * @param  string $line
     *         the line of text to extract columns from
     * @param  string $columnSeparator
     *         the column delimiter
     * @param  array $columnNos
     *         a list of the column numbers we are interested in
     * @return string
     *         the extracted columns
     */
    private static function filterLine($line, $columnSeparator, $columnNos)
    {
        $retval = [];
        $parts = array_filter(explode($columnSeparator, $line), function($part) {
            return (trim(rtrim($part)) != '');
        });

        $currentCol = 0;
        foreach($parts as $part) {
            if ($currentCol == $columnNos[0]) {
                $retval[] = $part;
                array_shift($columnNos);

                if (count($columnNos) == 0) {
                    break;
                }
            }

            $currentCol++;
        }

        return implode($columnSeparator, $retval);
    }
}