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
use pocketmine\plugin\PluginOwnedTrait;

class Language{
    use PluginOwnedTrait;

    public const FALLBACK_LOCALE = "eng";
    public const REGEX_ORIGINAL_FILE = '/^lang\/(.*)\/lang\.ini$/';
    public const REGEX_REPLACED_FILE = '/^lang\/(.*)\.ini$/';

    /** @var string locale name */
    protected $locale;

    /** @var string[] */
    protected $lang = [];

    /** @var string[] */
    protected $fallbackLang = [];

    /** @param PluginBase $owningPlugin */
    public function __construct(PluginBase $owningPlugin){
        $this->owningPlugin = $owningPlugin;

        //Load fallback language
        $resoruce = $owningPlugin->getResource("lang/" . self::FALLBACK_LOCALE . "/lang.ini");
        if($resoruce !== null){
            $this->fallbackLang = array_map("stripcslashes", parse_ini_string(stream_get_contents($resoruce), false, INI_SCANNER_RAW));
        }else{
            $owningPlugin->getLogger()->error("Missing fallback language file");
        }
    }

    /**
     * @param string   $id
     * @param mixed[] $params
     *
     * @return string
     */
    public function translate(string $id, array $params = []) : string{
        $str = $this->get($id);
        foreach($params as $i => $param){
            $str = str_replace("{%$i}", (string) $param, $str);
        }
        return $str;
    }

    public function get(string $id) : string{
        return $this->lang[$id] ?? $this->fallbackLang[$id] ?? $id;
    }

    /** @return string */
    public function getLocale() : string{
        return $this->locale;
    }

    /**
     * @param string $locale
     * @param bool   $noticeSelected for notice "Selected"
     *
     * @return bool
     */
    public function setLocale(string $locale, bool $noticeSelected = false) : bool{
        $localeList = $this->getLocales();
        $locale = strtolower($locale);
        $file = "{$this->owningPlugin->getDataFolder()}lang/$locale.ini";
        if(!in_array($locale, $localeList) || !file_exists($file)){
            $this->owningPlugin->getLogger()->error("Couldn't find the locale \"{$this->locale}\". (Availables : " . implode(", ", $localeList) . ")");
            return false;
        }

        $this->locale = $locale;
        $this->lang = array_map("stripcslashes", parse_ini_file($file, false, INI_SCANNER_RAW));

        if($noticeSelected){
            $this->owningPlugin->getLogger()->notice($this->translate("language.selected", [
                $this->translate("language.name"),
                $locale
            ]));
        }
        return true;
    }

    /**
     * Read available locale list from plugin data folder
     *
     * @return string[]
     */
    public function getLocales() : array{
        $localeList = [];
        $dataFolder = $this->owningPlugin->getDataFolder();
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
}