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
    public const FALLBACK_LANGUAGE = "eng";

    /** @var string */
    protected $langName;

    /** @var PluginBase */
    protected $plugin;

    /** @var string[] */
    protected $lang = [];

    /** @var string[] */
    protected $fallbackLang = [];

    /** @var string[] */
    protected $languageList;

    /**
     * @noinspection PhpMissingParentConstructorInspection
     * PluginLang constructor.
     *
     * @param PluginBase $plugin
     * @param string     $lang
     */
    public function __construct(PluginBase $plugin, string $lang){
        $this->langName = strtolower($lang);
        $this->plugin = $plugin;

        //Load required language
        $this->load($lang);

        //Load fallback language
        $resoruce = $plugin->getResource("lang/" . self::FALLBACK_LANGUAGE . "/lang.ini");
        if($resoruce !== null){
            $this->fallbackLang = array_map("stripcslashes", parse_ini_string(stream_get_contents($resoruce), false, INI_SCANNER_RAW));
        }else{
            $plugin->getLogger()->error("Missing fallback language file");
        }
    }

    /**
     * @param string $lang
     *
     * @return bool
     */
    public function load(string $lang) : bool{
        if($this->isAvailableLanguage($lang)){
            $file = "{$this->plugin->getDataFolder()}lang/{$this->langName}/lang.ini";
            if(file_exists($file)){
                $this->lang = array_map("stripcslashes", parse_ini_file($file, false, INI_SCANNER_RAW));
            }else{
                $this->plugin->getLogger()->error("Missing required language file ({$this->langName})");
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
    public function getLang() : string{
        return $this->langName;
    }

    /**
     * Read available language list from language.list file
     *
     * @return string[]
     */
    public function getLanguageList() : array{
        if($this->languageList === null){
            $this->languageList = [];
            $dataFolder = $this->plugin->getDataFolder();
            foreach(new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($dataFolder)) as $resource){
                if($resource->isFile()){
                    $path = str_replace(DIRECTORY_SEPARATOR, "/", substr((string) $resource, strlen($dataFolder)));
                    if(!preg_match('/^lang\/(.*)\/lang\.ini$/', $path, $matches) || !isset($matches[1]))
                        continue;
                    $this->languageList[] = $matches[1];
                }
            }
        }

        return $this->languageList;
    }

    /**
     * @param string $lang
     *
     * @return bool
     */
    public function isAvailableLanguage(string $lang) : bool{
        return in_array(strtolower($lang), $this->getLanguageList());
    }
}