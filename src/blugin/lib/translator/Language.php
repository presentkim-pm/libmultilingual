<?php

/*
 *
 *  ____  _             _         _____
 * | __ )| |_   _  __ _(_)_ __   |_   _|__  __ _ _ __ ___
 * |  _ \| | | | |/ _` | | '_ \    | |/ _ \/ _` | '_ ` _ \
 * | |_) | | |_| | (_| | | | | |   | |  __/ (_| | | | | | |
 * |____/|_|\__,_|\__, |_|_| |_|   |_|\___|\__,_|_| |_| |_|
 *                |___/
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author  Blugin team
 * @link    https://github.com/Blugin
 * @license https://www.gnu.org/licenses/lgpl-3.0 LGPL-3.0 License
 *
 *   (\ /)
 *  ( . .) ♥
 *  c(")(")
 */

declare(strict_types=1);

namespace blugin\lib\translator;

class Language{
    /** @var string locale name */
    protected $locale;

    /** @var string[] */
    protected $map = [];

    /**
     * @param array  $map
     * @param string $locale
     */
    public function __construct(array $map, string $locale){
        $this->map = $map;
        $this->locale = $locale;
    }

    /**
     * @param string $id
     *
     * @return string
     */
    public function get(string $id) : string{
        return $this->map[$id] ?? $id;
    }

    /** @return string */
    public function getLocale() : string{
        return $this->locale;
    }

    /**
     * Load language file from plugin data folder
     *
     * @param string $path
     * @param string $locale
     *
     * @return Language|null
     */
    public static function loadFrom(string $path, string $locale) : ?Language{
        if(!file_exists($path))
            return null;

        return new Language(array_map("stripcslashes", parse_ini_file($path, false, INI_SCANNER_RAW)), strtolower($locale));
    }
}