<?php

/*
 *
 *  ____                           _   _  ___
 * |  _ \ _ __ ___  ___  ___ _ __ | |_| |/ (_)_ __ ___
 * | |_) | '__/ _ \/ __|/ _ \ '_ \| __| ' /| | '_ ` _ \
 * |  __/| | |  __/\__ \  __/ | | | |_| . \| | | | | | |
 * |_|   |_|  \___||___/\___|_| |_|\__|_|\_\_|_| |_| |_|
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the MIT License. see <https://opensource.org/licenses/MIT>.
 *
 * @author  PresentKim (debe3721@gmail.com)
 * @link    https://github.com/PresentKim
 * @license https://opensource.org/licenses/MIT MIT License
 *
 *   (\ /)
 *  ( . .) ♥
 *  c(")(")
 */

declare(strict_types=1);

namespace kim\present\lib\translator;

class Language{
    /** @var string locale name */
    protected $locale;

    /** @var string[] id => text */
    protected $map = [];

    public function __construct(array $map, string $locale){
        $this->map = $map;
        $this->locale = $locale;
    }

    public function get(string $id) : string{
        return $this->map[$id] ?? $id;
    }

    public function getName() : string{
        return $this->get("language.name");
    }

    public function getLocale() : string{
        return $this->locale;
    }

    /**
     * @return Language|null the loaded language from file
     */
    public static function loadFrom(string $path, string $locale) : ?Language{
        if(!file_exists($path))
            return null;

        return new Language(array_map("stripcslashes", parse_ini_file($path, false, INI_SCANNER_RAW)), strtolower($locale));
    }
}