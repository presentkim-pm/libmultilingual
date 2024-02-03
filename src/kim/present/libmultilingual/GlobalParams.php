<?php

/**
 *  ____                           _   _  ___
 * |  _ \ _ __ ___  ___  ___ _ __ | |_| |/ (_)_ __ ___
 * | |_) | '__/ _ \/ __|/ _ \ '_ \| __| ' /| | '_ ` _ \
 * |  __/| | |  __/\__ \  __/ | | | |_| . \| | | | | | |
 * |_|   |_|  \___||___/\___|_| |_|\__|_|\_\_|_| |_| |_|
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author  PresentKim (debe3721@gmail.com)
 * @link    https://github.com/PresentKim
 * @license https://www.gnu.org/licenses/lgpl-3.0 LGPL-3.0 License
 *
 *   (\ /)
 *  ( . .) ♥
 *  c(")(")
 *
 * @noinspection PhpUnused
 */

declare(strict_types=1);

namespace kim\present\libmultilingual;

/**
 * This class manages the global parameters used for the Translator's translation.
 */
final class GlobalParams{
    private function __construct(){ }

    private const DEFAULTS = [
        "n" => "\n",
        "br" => "\n",
        "tab" => "\t",
        "t" => "\t"
    ];

    /** @var string[] The list of global translate parameters */
    private static array $params = self::DEFAULTS;

    /** @return array<string, string> The list of global translate parameters */
    public static function getAll() : array{
        return self::$params;
    }

    /**
     * Sets a global translate parameter
     *
     * @param string $paramName The parameter name
     * @param string $contents The parameter's replacement contents
     */
    public static function set(string $paramName, string $contents) : void{
        self::$params[$paramName] = $contents;
    }

    /**
     * Removes a global translate parameter
     *
     * @param string $paramName The parameter name
     */
    public static function remove(string $paramName) : void{
        unset(self::$params[$paramName]);
    }
}