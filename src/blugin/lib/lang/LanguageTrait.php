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

use blugin\lifespan\lang\PluginLang;
use pocketmine\plugin\PluginBase;

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
     * @param string|null $lang
     */
    public function loadLanguage(?string $lang = null) : void{
        $this->saveLanguageResources();
        $this->language = new Language($this, $lang);
    }

    public function saveLanguageResources(){
        /** @var PluginBase $this */
        $langFiles = array_filter($this->getResources(), function(string $key){
            return preg_match('/^lang(.*)\.ini$/', $key);
        }, ARRAY_FILTER_USE_KEY);

        foreach($langFiles as $key => $info){
            $this->saveResource($key, false);
            $this->saveResource($key, false);
            $this->saveResource($key, false);
        }
    }

    /**
     * @Override for multilingual support of the config file
     *
     * @return bool
     */
    public function saveDefaultConfig() : bool{
        /** @var PluginBase $this */
        $resource = $this->getResource("lang/{$this->getServer()->getLanguage()->getLang()}/config.yml");
        if($resource === null){
            $resource = $this->getResource("lang/" . Language::FALLBACK_LANGUAGE . "/config.yml");
        }

        /** @see PluginBase::getDataFolder() */
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