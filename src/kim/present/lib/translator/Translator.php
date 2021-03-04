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
 * @author  PresentKim (debe3721@gmail.com)
 * @link    https://github.com/PresentKim
 * @license https://www.gnu.org/licenses/lgpl-3.0 LGPL-3.0 License
 *
 *   (\ /)
 *  ( . .) ♥
 *  c(")(")
 *
 * @noinspection PhpIllegalPsrClassPathInspection
 * @noinspection SpellCheckingInspection
 * @noinspection PhpDocSignatureInspection
 */

declare(strict_types=1);

namespace kim\present\lib\translator;

use kim\present\converter\locale\LocaleConverter;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use RuntimeException;

use function array_keys;
use function array_map;
use function array_merge;
use function explode;
use function fclose;
use function is_dir;
use function method_exists;
use function parse_ini_string;
use function preg_match;
use function scandir;
use function sprintf;
use function str_replace;
use function stream_get_contents;
use function strlen;
use function strtolower;

class Translator{
    /** Owner plugin */
    protected PluginBase $plugin;

    /** @var Language[] Language instances */
    protected array $languages = [];

    /** Default language */
    public ?Language $defaultLanguage = null;

    public function __construct(PluginBase $owningPlugin){
        $this->plugin = $owningPlugin;

        $this->loadAllLocale();

        $locale = $owningPlugin->getServer()->getLanguage()->getLang();
        $resource = $owningPlugin->getResource(sprintf("locale/%s.ini", $locale));
        if($resource === null){
            //Use the first searched file as fallback
            foreach($owningPlugin->getResources() as $filePath => $info){
                if(!preg_match("/^locale\/([a-zA-Z]{3})\.ini$/", $filePath, $matches) || !isset($matches[1]))
                    continue;

                $locale = $matches[1];
                $resource = $owningPlugin->getResource($filePath);
                if($resource !== null)
                    break;
            }
        }
        if($resource !== null){
            $this->setDefaultLanguage(new Language(array_map("stripcslashes", parse_ini_string(stream_get_contents($resource), false, INI_SCANNER_RAW)), strtolower($locale)));
            fclose($resource);
        }
    }

    /**
     * @param string      $str original string
     * @param mixed[]     $params translate parameters
     * @param string|null $locale translate language locale. if null, translate by default language
     *
     * @return string the translated string
     */
    public function translate(string $str, array $params = [], ?string $locale = null) : string{
        $params = array_merge($params, DefautParams::getAll());
        $lang = $this->getLanguage($locale);
        if($lang !== null){
            $parts = explode("%", $str);
            $str = "";
            $lastTranslated = false;
            foreach($parts as $_ => $part){
                $new = $lang->getExact($part) ?? $this->defaultLanguage->get($part);
                if(strlen($str) > 0 && $part === $new && !$lastTranslated){
                    $str .= "%";
                }
                $lastTranslated = $part !== $new;

                $str .= $new;
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

    /** @return Language|null if $locale is null, return default language */
    public function getLanguage(?string $locale = null) : ?Language{
        return $this->languages[strtolower($locale ?? Server::getInstance()->getLanguage()->getLang())] ?? $this->defaultLanguage;
    }

    /** @return Language[] */
    public function getLangList() : array{
        return $this->languages;
    }

    /** @return string[] */
    public function getLocaleList() : array{
        return array_keys($this->getLangList());
    }

    public function getDefaultLanguage() : ?Language{
        return $this->defaultLanguage;
    }

    public function setDefaultLanguage(?Language $defaultLanguage) : void{
        $this->defaultLanguage = $defaultLanguage;
    }

    /** Load all locale file from plugin data folder */
    public function loadAllLocale() : void{
        $path = $this->plugin->getDataFolder() . "locale/";
        if(!is_dir($path))
            throw new RuntimeException("Language directory $path does not exist or is not a directory");

        foreach(scandir($path, SCANDIR_SORT_NONE) as $_ => $filename){
            if(!preg_match('/^([a-zA-Z]{3})\.ini$/', $filename, $matches) || !isset($matches[1]))
                continue;

            $this->languages[$matches[1]] = Language::loadFrom($path . $filename, $matches[1]);
        }
    }

    public function getPlugin() : PluginBase{
        return $this->plugin;
    }
}