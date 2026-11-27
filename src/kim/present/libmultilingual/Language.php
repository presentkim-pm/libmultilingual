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
 * @author       PresentKim (debe3721@gmail.com)
 * @link         https://github.com/PresentKim
 * @license      https://www.gnu.org/licenses/lgpl-3.0 LGPL-3.0 License
 *
 *   (\ /)
 *  ( . .) ♥
 *  c(")(")
 *
 * @noinspection PhpUnused
 */

declare(strict_types=1);

namespace kim\present\libmultilingual;

class Language{

    /** @var string Locale name (ISO_639-3 code) */
    protected string $locale;

    /**
     * @param array<string, string> $map    id => text
     * @param string                $locale Locale name (ISO_639-3 code)
     */
    public function __construct(
        protected array $map,
        string $locale
    ){
        $this->locale = strtolower($locale);
    }

    public function getLocale() : string{
        return $this->locale;
    }

    public function get(string $id) : ?string{
        return $this->map[$id] ?? null;
    }

    public function getNonNull(string $id) : string{
        return $this->map[$id] ?? $id;
    }

    public function getName() : string{
        return $this->getNonNull("language.name");
    }

    /**
     * Parses INI contents. Malformed contents never emit warnings or throw; the lines that cannot be parsed result in
     * an empty language.
     * Quoted values lose their surrounding double quotes, and C-style escapes (e.g. `\n`) are unescaped.
     * Section headers and array-style keys (`a[b] = c`) are not supported, such entries are ignored.
     */
    public static function fromContents(string $contents, string $locale) : Language{
        // parse_ini_string() emits a warning on syntax errors, which PocketMine's error handler turns into an exception
        set_error_handler(static fn() : bool => true);
        try{
            $parsed = parse_ini_string($contents, false, INI_SCANNER_RAW);
        }finally{
            restore_error_handler();
        }
        if($parsed === false){
            return new Language([], $locale);
        }

        $map = [];
        foreach($parsed as $key => $value){
            if(is_string($value)){
                $map[(string) $key] = stripcslashes($value);
            }
        }
        return new Language($map, $locale);
    }

    public static function fromFile(string $path, string $locale) : ?Language{
        if(!is_file($path)){
            return null;
        }

        $contents = @file_get_contents($path);
        if($contents === false){
            return null;
        }
        return self::fromContents($contents, $locale);
    }
}
