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

use GanbaroDigital\Reflection\Requirements\RequireStringy;
use GanbaroDigital\Reflection\Requirements\RequireTraversable;
use GanbaroDigital\Reflection\ValueBuilders\LookupMethodByType;
use GanbaroDigital\Reflection\ValueBuilders\SimpleType;
use GanbaroDigital\TextTools\Exceptions\E4xx_UnsupportedType;

class FilterOutEmptyValues
{
    use LookupMethodByType;

    /**
     * filter out any empty values from $input
     *
     * @param  mixed $input
     *         the data to filter
     * @return mixed the filtered data
     *         if $input is Traverseable, always returns an array
     *         if $input is a string, returns string|null
     */
    public function __invoke($input)
    {
        return self::from($input);
    }

    /**
     * filter out any empty values from $input
     *
     * @param  mixed $input
     *         the data to filter
     * @return mixed the filtered data
     *         if $input is Traverseable, always returns an array
     *         if $input is a string, returns string|null
     */
    public static function from($input)
    {
        $method = self::lookupMethodFor($input, self::$dispatchTable);
        return self::$method($input);
    }

    /**
     * called by self::from() when $input is a data type that we currently
     * do not support
     *
     * @param  mixed $input
     * @return void
     */
    private static function nothingMatchesTheInputType($input)
    {
        throw new E4xx_UnsupportedType(SimpleType::from($input));
    }

    /**
     * filter out any empty values from $input
     *
     * @param  callable $input
     *         a function that will return the data to filter
     * @return mixed the filtered data
     */
    private static function fromCallable($callable)
    {
        $input = $callable();
        return self::from($input);
    }

    /**
     * filter out any empty values from $input
     *
     * @param  array|Traversable $input
     *         the data to filter
     * @return array the filtered data
     */
    private static function fromTraversable($input)
    {
        $retval = [];

        foreach ($input as $item) {
            $filtered = self::from($item);
            if ($filtered !== null) {
                $retval[] = $item;
            }
        }

        return $retval;
    }

    /**
     * filter out any empty values from $input
     *
     * @param  string $input
     *         the data to filter
     * @return string|null the filtered data
     *         returns $input if $input is not empty
     *         returns NULL otherwise
     */
    private static function fromString($input)
    {
        if (strlen(trim((string) $input)) === 0) {
            return null;
        }

        return $input;
    }

    /**
     * filter out empty values from $input
     *
     * this is here to help us strip NULLs out of arrays
     *
     * @param  null $input
     *         the data to strip
     * @return null
     */
    private static function fromNull($input)
    {
        return $input;
    }

    /**
     * tells us which method to call for which input data type
     *
     * @var array
     */
    private static $dispatchTable = [
        'Callable' => 'fromCallable',
        'NULL' => 'fromNull',
        'String' => 'fromString',
        'Traversable' => 'fromTraversable',
    ];
}