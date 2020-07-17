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

use pocketmine\plugin\PluginBase;

class Language{
    public const FALLBACK_LOCALE = "eng";
    public const REGEX_ORIGNINAL_FILE = '/^lang\/(.*)\/lang\.ini$/';
    public const REGEX_REPLACED_FILE = '/^lang\/(.*)\.ini$/';

    /** @var PluginBase owner plugin */
    protected $plugin;

    /** @var string locale name */
    protected $locale;

    /** @var string[] */
    protected $lang = [];

    /** @var string[] */
    protected $fallbackLang = [];

    /** @param PluginBase $plugin */
    public function __construct(PluginBase $plugin){
        $this->plugin = $plugin;

        //Load fallback language
        $resoruce = $plugin->getResource("lang/" . self::FALLBACK_LOCALE . "/lang.ini");
        if($resoruce !== null){
            $this->fallbackLang = array_map("stripcslashes", parse_ini_string(stream_get_contents($resoruce), false, INI_SCANNER_RAW));
        }else{
            $plugin->getLogger()->error("Missing fallback language file");
        }
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
        if($this->isAvailableLocale($locale)){
            $this->locale = strtolower($locale);
            $file = "{$this->plugin->getDataFolder()}lang/{$this->locale}.ini";
            if(file_exists($file)){
                $this->lang = array_map("stripcslashes", parse_ini_file($file, false, INI_SCANNER_RAW));
            }else{
                $this->plugin->getLogger()->error("Missing required language file ({$this->locale})");
            }
        }
        return false;
    }

    /**
     * @param string   $id
     * @param string[] $params
     *
     * @return string
     */
    public function translate(string $id, array $params = []) : string{
        $str = $this->lang[$id] ?? $this->fallbackLang[$id] ?? $id;
        foreach($params as $i => $param){
            $str = str_replace("{%$i}", (string) $param, $str);
        }
        return $str;
    }

    /**
     * @return string
     */
    public function getName() : string{
        return $this->translate("language.name");
    }

    /**
     * @return string
     */
    public function getLocale() : string{
        return $this->locale;
    }

    /**
     * Read available locale list from plugin data folder
     *
     * @return string[]
     */
    public function getLocales() : array{
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
     * @param string $locale
     *
     * @return bool
     */
    public function isAvailableLocale(string $locale) : bool{
        return in_array(strtolower($locale), $this->getLocales());
    }
}