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
use GanbaroDigital\Reflection\ValueBuilders\FirstMethodMatchingType;
use GanbaroDigital\TextTools\Exceptions\E4xx_UnsupportedType;

class FilterForMatchingRegex
{
    /**
     * return the input string if it matches the search regex
     *
     * @param  string $data
     *         the input string to check
     * @param  string $searchRegex
     *         the regex to match
     * @return string|null
     *         returns $data if it matches the regex
     *         returns NULL otherwise
     */
    public static function againstString($data, $searchRegex)
    {
        // robustness!
        RequireStringy::checkMixed($data, E4xx_UnsupportedType::class);
        RequireStringy::checkMixed($searchRegex, E4xx_UnsupportedType::class);

        return self::matchLine($data, $searchRegex);
    }

    /**
     * return the array values that match the search regex
     *
     * @param  array|Traversable $data
     *         the collection of input strings to check
     * @param  string $searchRegex
     *         the regex to match
     * @return array
     *         returns the elements of $data that match the regex
     *         will be an empty array if no matches found
     */
    public static function againstTraversable($data, $searchRegex)
    {
        // robustness!
        RequireTraversable::checkMixed($data, E4xx_UnsupportedType::class);
        RequireStringy::checkMixed($searchRegex, E4xx_UnsupportedType::class);

        return self::matchArray($data, $searchRegex);
    }

    /**
     * return the parts of $data that match the regex
     *
     * @param  mixed $data
     *         the collection of input strings to check
     * @param  string $searchRegex
     *         the regex to match
     * @return mixed|null
     *         returns the parts of $data that match the regex
     *         returns NULL otherwise
     */
    public static function against($data, $searchRegex)
    {
        $method = FirstMethodMatchingType::fromMixed($data, self::class, 'against', E4xx_UnsupportedType::class);
        return self::$method($data, $searchRegex);
    }

    /**
     * return the parts of $data that match the regex
     *
     * @param  mixed $data
     *         the collection of input strings to check
     * @param  string $searchRegex
     *         the regex to match
     * @return mixed|null
     *         returns the parts of $data that match the regex
     *         returns NULL otherwise
     */
    public function __invoke($data, $searchRegex)
    {
        return self::against($data, $searchRegex);
    }

    /**
     * search an array for values that match the regex
     *
     * @param  array|Traversable $data
     *         the array to search
     * @param  string $searchRegex
     *         the regex to match
     * @return array
     *         only those values of $data that match the regex
     */
    private static function matchArray($data, $searchRegex)
    {
        $retval = [];

        foreach ($data as $line) {
            RequireStringy::checkMixed($line, E4xx_UnsupportedType::class);
            $match = self::matchLine($line, $searchRegex);

            if (!empty($match)) {
                $retval[] = $match;
            }
        }

        // all done
        return $retval;
    }

    /**
     * does the input string match the regex?
     *
     * @param  string $line
     *         the input string to check
     * @param  string $searchRegex
     *         the regex to match
     * @return string|null
     *         returns $line if it matches the regex
     *         returns NULL otherwise
     */
    private static function matchLine($line, $searchRegex)
    {
        if (preg_match($searchRegex, $line)) {
            return $line;
        }

        return null;
    }
}