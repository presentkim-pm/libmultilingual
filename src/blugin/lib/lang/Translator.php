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

namespace blugin\lib\lang;

use pocketmine\plugin\Plugin;
use pocketmine\plugin\PluginBase;

class Translator{
    /** @var Plugin */
    private $plugin;

    public const REGEX_ORIGINAL_FILE = '/^lang\/(.*)\/lang\.ini$/';
    public const REGEX_REPLACED_FILE = '/^lang\/(.*)\.ini$/';

    /** @var string locale name */
    protected $locale;

    /** @var string[] */
    protected $lang = [];

    /** @var string[] */
    protected $fallbackLang = [];

    /** @param PluginBase $plugin */
    public function __construct(PluginBase $plugin){
        $this->plugin = $plugin;

        $this->loadAllLocale();
    }

    /**
     * @param string      $id
     * @param mixed[]     $params
     * @param string|null $locale
     *
     * @return string
     */
    public function translate(string $id, array $params = [], ?string $locale = null) : string{
        $str = $this->get($id, $locale);
        foreach($params as $i => $param){
            $str = str_replace("{%$i}", (string) $param, $str);
        }
        return $str;
    }

    /**
     * @param string      $id
     * @param string|null $locale
     *
     * @return string
     */
    public function get(string $id, ?string $locale = null) : string{
        $locale = $locale ?? $this->getLocale();
        $lang = $this->lang[$locale] ?? [];
        return $lang[$id] ?? $this->fallbackLang[$id] ?? $id;
    }

    /** @return string */
    public function getLocale() : string{
        return $this->locale;
    }

    /**
     * @param string $locale
     *
     * @return bool
     */
    public function setLocale(string $locale) : bool{
        $locale = strtolower($locale);
        if(!isset($this->lang[$locale])){
            $lang = $this->loadLocale($locale);
            if(!$lang)
                return false;

            $this->lang[$locale] = $lang;
        }

        $this->locale = strtolower($locale);
        return true;
    }

    /**
     * Read available locale list from plugin data folder
     *
     * @return string[]
     */
    public function getAvailableLocales() : array{
        $localeList = [];
        $dataFolder = $this->plugin->getDataFolder();
        foreach(new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($dataFolder)) as $resource){
            if($resource->isFile()){
                $path = str_replace(DIRECTORY_SEPARATOR, "/", substr((string) $resource, strlen($dataFolder)));
                if(!preg_match(self::REGEX_REPLACED_FILE, $path, $matches) || !isset($matches[1]))
                    continue;
                $localeList[] = $matches[1];
            }
        }

        return $localeList;
    }

    /**
     * Load locale file from plugin data folder
     *
     * @param string $locale
     *
     * @return string[]|null
     */
    public function loadLocale(string $locale) : ?array{
        $localeList = $this->getAvailableLocales();
        $locale = strtolower($locale);
        $file = "{$this->plugin->getDataFolder()}lang/$locale.ini";
        if(!in_array($locale, $localeList) || !file_exists($file))
            return null;

        return array_map("stripcslashes", parse_ini_file($file, false, INI_SCANNER_RAW));
    }

    /**
     * Load all locale file from plugin data folder
     *
     */
    public function loadAllLocale() : void{
        foreach($this->getAvailableLocales() as $_ => $locale){
            $this->lang[$locale] = $this->loadLocale($locale);
        }
    }

    public function getPlugin() : Plugin{
        return $this->plugin;
    }
}