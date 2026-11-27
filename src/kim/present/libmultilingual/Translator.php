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
     * @param Language[]    $languages        Language instances
     * @param Language|null $fallbackLanguage Fallback language
     */
    public function __construct(
        array $languages = [],
        ?Language $fallbackLanguage = null
    ){
        foreach($languages as $language){
            $this->languages[strtolower($language->getLocale())] = $language;
        }

        if($fallbackLanguage === null && !isset($this->languages[PMLanguage::FALLBACK_LANGUAGE])){
            throw new RuntimeException("Fallback language is not provided. You must provides a fallback language("
                . PMLanguage::FALLBACK_LANGUAGE . ")");
        }

        $this->fallbackLanguage = $fallbackLanguage ?? $this->languages[PMLanguage::FALLBACK_LANGUAGE];
    }

    /**
     * @param string                          $str    original string
     * @param array<string|Stringable|number> $params translate parameters
     * @param string|object|null              $locale translate language locale or translate target. if null, translate
     *                                                by default language (fallback language when no server is running)
     *
     * @return string the translated string
     */
    public function translate(string $str, array $params = [], string|object|null $locale = null) : string{
        // Caller's params take precedence over the global params, and keys (including numeric ones) are preserved
        $params += GlobalParams::getAll();
        if(is_object($locale)){
            $server = self::getServer();
            if($server !== null && method_exists($locale, "getLocale") && !$server->isLanguageForced()){
                $locale = LocaleConverter::convertIETF($locale->getLocale());
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

        // Replace in a single pass, so that a replaced value is never scanned for placeholders again
        return preg_replace_callback(
            "/\{%([a-zA-Z0-9]+)\}/",
            static function(array $matches) use ($params) : string{
                $param = $matches[1];
                if(isset($params[$param])){
                    return (string) $params[$param];
                }
                return self::decodeUnicodeParam($param) ?? $matches[0];
            },
            $str
        ) ?? $str;
    }

    /**
     * Decodes a `u` + 1~6 hex digits unicode code point parameter name (ex: `u1F600`) to a UTF-8 character.
     *
     * @return string|null null if the name is not a valid unicode code point parameter
     */
    private static function decodeUnicodeParam(string $param) : ?string{
        if(preg_match("/^u([0-9A-Fa-f]{1,6})$/", $param, $matches) !== 1){
            return null;
        }

        $codePoint = hexdec($matches[1]);
        if($codePoint > 0x10FFFF || ($codePoint >= 0xD800 && $codePoint <= 0xDFFF)){
            return null;
        }
        $char = mb_chr((int) $codePoint, "UTF-8");
        return $char === false ? null : $char;
    }

    /** Returns the running server, or null when there is none (unit tests, tools, other threads) */
    private static function getServer() : ?Server{
        try{
            return Server::getInstance();
        }catch(RuntimeException){
            return null;
        }
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
        $locale ??= self::getServer()?->getLanguage()->getLang();
        if($locale === null){
            return $this->fallbackLanguage;
        }

        $locale = strtolower($locale);
        return $this->languages[$locale]
            ?? $this->languages[LocaleConverter::LEGACY_ALIASES[$locale] ?? ""]
            ?? $this->fallbackLanguage;
    }

    public function getFallbackLanguage() : Language{
        return $this->fallbackLanguage;
    }

    public function setFallbackLanguage(Language $fallbackLanguage) : void{
        $this->fallbackLanguage = $fallbackLanguage;
    }

    /**
     * Add or replace a language in the translator.
     *
     * @see Translator::removeLanguage()
     */
    public function addLanguage(Language $language) : void{
        $this->languages[strtolower($language->getLocale())] = $language;
    }

    /**
     * Remove a language by locale.
     * Does not remove the fallback language reference; getLanguage() will still return fallback for unknown locales.
     *
     * @see Translator::addLanguage()
     */
    public function removeLanguage(string $locale) : void{
        unset($this->languages[strtolower($locale)]);
    }

    /**
     * Check if a translation key exists in the given locale (or server default if null).
     *
     * @param string      $key    Translation key to look up
     * @param string|null $locale Locale code, or null for server language
     *
     * @return bool true if the key exists in the language
     */
    public function hasKey(string $key, ?string $locale = null) : bool{
        return $this->getLanguage($locale)->get($key) !== null;
    }
}
