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

namespace blugin\lib\translator;

use blugin\lib\converter\locale\LocaleConverter;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;

class Translator{
    /** @var PluginBase */
    protected $plugin;

    /** @var string locale name */
    protected $defaultLocale;

    /** @var Language[] */
    protected $lang = [];

    public function __construct(PluginBase $owningPlugin){
        $this->plugin = $owningPlugin;

        $this->loadAllLocale();
        $this->defaultLocale = Server::getInstance()->getLanguage()->getLang();
    }

    /**
     * @param string      $str original string
     * @param mixed[]     $params translate parameters
     * @param string|null $locale translate language locale. if null, translate by default language
     *
     * @return string the translated string
     */
    public function translate(string $str, array $params = [], ?string $locale = null) : string{
        $lang = $this->getLang($locale);
        if($lang !== null){
            if(strpos($str, "%") === false){
                $str = $lang->get($str);
            }else{
                $parts = explode("%", $str);
                $str = "";
                $lastTranslated = false;
                foreach($parts as $_ => $part){
                    $new = $lang->get($part);
                    if(strlen($str) > 0 && $part === $new && !$lastTranslated){
                        $str .= "%";
                    }
                    $lastTranslated = $part !== $new;

                    $str .= $new;
                }
            }
        }
        foreach($params as $i => $param){
            $str = str_replace("{%$i}", (string) $param, $str);
        }
        return $str;
    }

    /**
     * @param string             $str original string
     * @param mixed[]            $params translate parameters
     * @param CommandSender|null $sender translate target sender. if null, translate by default language
     *
     * @return string
     */
    public function translateTo(string $str, array $params, ?CommandSender $sender = null) : string{
        $locale = null;
        if($sender !== null && method_exists($sender, 'getLocale') && !Server::getInstance()->isLanguageForced()){
            $locale = LocaleConverter::convertIEFT($sender->getLocale());
        }
        return $this->translate($str, $params, $locale);
    }

    /**
     * @return Language|null if $locale is null, return default language
     */
    public function getLang(?string $locale = null) : ?Language{
        $locale = $locale === null ? $this->getDefaultLocale() : strtolower($locale);
        return $this->lang[$locale] ?? $this->lang[Server::getInstance()->getLanguage()->getLang()] ?? $this->lang["eng"] ?? null;
    }

    /** @return Language[] */
    public function getLangList() : array{
        return $this->lang;
    }

    public function getDefaultLocale() : string{
        return $this->defaultLocale;
    }

    /** @return string[] */
    public function getLocaleList() : array{
        return array_keys($this->getLangList());
    }

    public function setDefaultLocale(string $locale) : bool{
        $locale = strtolower($locale);
        if(!isset($this->lang[$locale]))
            return false;

        $this->defaultLocale = strtolower($locale);
        return true;
    }

    /**
     * Load all locale file from plugin data folder
     */
    public function loadAllLocale() : void{
        $path = $this->plugin->getDataFolder() . "locale/";
        if(!is_dir($path))
            throw new \RuntimeException("Language directory $path does not exist or is not a directory");

        foreach(scandir($path, SCANDIR_SORT_NONE) as $_ => $filename){
            if(!preg_match('/^([a-zA-Z]{3})\.ini$/', $filename, $matches) || !isset($matches[1]))
                continue;

            $this->lang[$matches[1]] = Language::loadFrom($path . $filename, $matches[1]);
        }
    }

    public function getPlugin() : PluginBase{
        return $this->plugin;
    }
}