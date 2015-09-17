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

use GanbaroDigital\Reflection\Requirements\RequireStringy;
use GanbaroDigital\Reflection\ValueBuilders\LookupMethodByType;
use GanbaroDigital\Reflection\ValueBuilders\SimpleType;
use GanbaroDigital\TextTools\Exceptions\E4xx_UnsupportedType;
use Traversable;

class TrimWhitespace
{
    use LookupMethodByType;

    /**
     * remove leading and trailing whitespace from $data
     *
     * @param  mixed $data
     *         the data that needs trimming
     * @return mixed
     *         the (possibly) changed $data
     */
    public function __invoke($data)
    {
        return self::from($data);
    }

    /**
     * remove leading and trailing whitespace from $data
     *
     * @param  mixed $data
     *         the data that needs trimming
     * @return mixed
     *         the (possibly) changed $data
     */
    public static function from($data)
    {
        $method = self::lookupMethodFor($data, self::$dispatchTable);
        return self::$method($data);
    }

    /**
     * remove leading and trailing whitespace from $data
     *
     * @param  array|Traversable $data
     *         the data that needs trimming
     * @return array
     *         the (possibly) changed $data
     */
    private static function fromArray($data)
    {
        $retval = [];

        foreach ($data as $datum) {
            RequireStringy::check($datum, E4xx_UnsupportedType::class);
            $retval[] = trim($datum);
        }

        return $retval;
    }

    /**
     * remove leading and trailing whitespace from $data
     *
     * @param  string $data
     *         the data that needs trimming
     * @return string
     *         the (possibly) changed $data
     */
    private static function fromString($data)
    {
        return trim($data);
    }

    /**
     * called by self::in() when $data is an unsupported data type
     */
    private static function nothingMatchesTheInputType($data)
    {
        throw new E4xx_UnsupportedType(SimpleType::from($data));
    }

    /**
     * our list of supported data types, and the methods to dispatch them do
     * @var array
     */
    private static $dispatchTable = [
        'Array' => 'fromArray',
        'String' => 'fromString',
        'Traversable' => 'fromArray',
    ];
}