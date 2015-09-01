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

use GanbaroDigital\Reflection\Requirements\RequireNumeric;
use GanbaroDigital\Reflection\Requirements\RequireTraversable;
use GanbaroDigital\Reflection\Requirements\RequireStringy;
use GanbaroDigital\Reflection\ValueBuilders\FirstMethodMatchingType;
use GanbaroDigital\TextTools\Exceptions\E4xx_UnsupportedType;

class ExpandRange
{
    /**
     * expand a list of ranges
     *
     * @param  array|Traversable $data
     *         the list of ranges to expand
     * @return array
     *         the expanded ranges
     */
    public static function fromArray($data)
    {
        // robustness!
        RequireTraversable::checkMixed($data, E4xx_UnsupportedType::class);

        $retval=[];
        foreach ($data as $key => $range) {
            $retval[$key] = self::fromString($range);
        }

        return $retval;
    }

    /**
     * expand a range in the form "n-m"
     *
     * @param  string $data
     *         the range to expand
     * @return array
     *         the values are the range
     */
    public static function fromString($data)
    {
        RequireStringy::checkMixed($data, E4xx_UnsupportedType::class);

        $regex = "/([0-9]+)-([0-9]+)/";
        if (!preg_match($regex, $data, $matches)) {
            throw new E4xx_CannotParseRange($data);
        }

        $min = min((int)$matches[1], (int)$matches[2]);
        $max = max((int)$matches[1], (int)$matches[2]);

        return range($min, $max);
    }

    /**
     * expand a range in the form "n-m"
     *
     * @param  mixed $data
     *         the range to expand
     * @return mixed
     *         the values are the range
     */
    public static function from($data)
    {
        $method = FirstMethodMatchingType::fromMixed($data, self::class, 'from', E4xx_UnsupportedType::class);
        return self::$method($data, $columnNos, $columnSeparator, $lineSeparator);
    }

    /**
     * expand a range in the form "n-m"
     *
     * @param  mixed $data
     *         the range to expand
     * @return mixed
     *         the values are the range
     */
    public function __invoke($data)
    {
        return self::from($data);
    }
}