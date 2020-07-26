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
use pocketmine\utils\AssumptionFailedError;

/**
 * This trait override most methods in the {@link PluginBase} abstract class.
 */
trait LanguageTrait{
    /** @var Language */
    private $language;

    /** @return Language */
    public function getLanguage() : Language{
        return $this->language;
    }

    /**
     * Load language with save default language resources
     *
     * @param string|null $locale
     */
    public function loadLanguage(?string $locale = null) : void{
        $this->saveLanguageResources();
        /** @noinspection PhpParamsInspection */
        $this->language = new Language($this);
        if(!empty($locale)){
            $this->language->setLocale($locale);
        }
    }

    public function saveLanguageResources(){
        $langFolder = $this->getDataFolder() . "lang/";
        if(!file_exists($langFolder)){
            mkdir($langFolder, 0755, true);
        }

        foreach($this->getResources() as $key => $_){
            if(!preg_match('/^lang\/(.*)\/lang\.ini$/', $key, $matches) || !isset($matches[1]))
                continue;

            $out = $langFolder . $matches[1] . ".ini";
            if(file_exists($out))
                continue;

            $fp = fopen($out, "wb");
            if($fp === false)
                throw new AssumptionFailedError("fopen() should not fail with wb flags");

            $resource = $this->getResource($key);
            stream_copy_to_stream($resource, $fp);
            fclose($fp);
            fclose($resource);
        }
    }

    /**
     * @Override for multilingual support of the config file
     *
     * @return bool
     */
    public function saveDefaultConfig() : bool{
        $resource = $this->getResource("lang/{$this->getServer()->getLanguage()->getLang()}/config.yml");
        if($resource === null){
            $resource = $this->getResource("lang/" . Language::FALLBACK_LOCALE . "/config.yml");
        }

        $configFile = "{$this->getDataFolder()}config.yml";
        if(!file_exists($configFile)){
            $ret = stream_copy_to_stream($resource, $fp = fopen($configFile, "wb")) > 0;
            fclose($fp);
            fclose($resource);
            return $ret;
        }
        return false;
    }
}