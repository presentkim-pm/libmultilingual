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
 * @noinspection PhpUnused
 */

declare(strict_types=1);

namespace kim\present\libmultilingual;

use kim\present\libmultilingual\utils\LocaleConverter;
use pocketmine\lang\Language as PMLanguage;
use pocketmine\Server;
use RuntimeException;
use Stringable;

class Translator{
    /** @var Language[] Language instances */
    protected array $languages = [];

    /** @var Language Language|null Fallback language */
    protected Language $fallbackLanguage;

    /**
     * @param $languages Language[] Language instances
     * @param $fallbackLanguage Language|null Fallback language
     */
    public function __construct(
        array $languages = [],
        ?Language $fallbackLanguage = null
    ){
        foreach($languages as $language){
            $this->languages[strtolower($language->getLocale())] = $language;
        }

        if($fallbackLanguage === null && !isset($this->languages[PMLanguage::FALLBACK_LANGUAGE])){
            throw new RuntimeException("Fallback language is not provided. You must provides a fallback language(" . PMLanguage::FALLBACK_LANGUAGE . ")");
        }

        $this->fallbackLanguage = $fallbackLanguage ?? $this->languages[PMLanguage::FALLBACK_LANGUAGE];
    }

    /**
     * @param string                          $str original string
     * @param array<string|Stringable|number> $params translate parameters
     * @param string|object|null              $locale translate language locale or translate target. if null, translate by default language
     *
     * @return string the translated string
     */
    public function translate(string $str, array $params = [], string|object|null $locale = null) : string{
        $params = array_merge($params, GlobalParams::getAll());
        if(is_object($locale)){
            if(method_exists($locale, "getLocale") && !Server::getInstance()->isLanguageForced()){
                $locale = LocaleConverter::convertIEFT($locale->getLocale());
            }else{
                $locale = null;
            }
        }
        $lang = $this->getLanguage($locale);
        $parts = explode("%", $str);
        $str = "";
        $lastTranslated = false;
        foreach($parts as $part){
            $new = $lang->get($part) ?? $this->fallbackLanguage->getNonNull($part);
            if($str !== "" && $part === $new && !$lastTranslated){
                $str .= "%";
            }
            $lastTranslated = $part !== $new;

            $str .= $new;
        }

        if(preg_match_all("/\{%([a-zA-Z0-9]+)\}/", $str, $paramMatches, PREG_SET_ORDER) !== false){
            foreach($paramMatches as [$matches, $param]){
                if(isset($params[$param])){
                    $str = str_replace($matches, $params[$param], $str);
                }elseif(preg_match("/u[A-Fa-f0-9]+/", $param)){
                    $binary = hex2bin(substr($param, 1));
                    $unicodeChar = mb_convert_encoding($binary, "UTF-8", "UTF-16BE");

                    $str = str_replace($matches, $unicodeChar, $str);

                    // Caching unicode charactor to GlobalParams
                    GlobalParams::set($param, $unicodeChar);
                }
            }
        }
        return $str;
    }

    /** @return Language[] */
    public function getLanguages() : array{
        return $this->languages;
    }

    /** @return string[] */
    public function getLocaleList() : array{
        return array_keys($this->getLanguages());
    }

    /** @return Language if $locale is null, return fallback language */
    public function getLanguage(?string $locale = null) : Language{
        return $this->languages[strtolower($locale ?? Server::getInstance()->getLanguage()->getLang())] ?? $this->fallbackLanguage;
    }

    public function getFallbackLanguage() : Language{
        return $this->fallbackLanguage;
    }

    public function setFallbackLanguage(Language $fallbackLanguage) : void{
        $this->fallbackLanguage = $fallbackLanguage;
    }
}