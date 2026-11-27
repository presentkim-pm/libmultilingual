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

namespace kim\present\libmultilingual\utils;

final class LocaleConverter{

    private function __construct(){}

    /**
     * @var string[] IETF_language_tag => ISO_639-3 code
     *
     * @link https://en.wikipedia.org/wiki/IETF_language_tag
     * @link https://en.wikipedia.org/wiki/ISO_639-3
     *
     * The list was taken from language_names.json in the Minecraft resource.
     * @link https://github.com/ZtechNetwork/MCBVanillaResourcePack/blob/cd647b3/texts/language_names.json
     *
     * Codes of languages that PocketMine ships (bul, chs, deu, eng, fra, ita, jpn, kor, lav, nld, rus, spa, tur, vie)
     * follow PocketMine's file names, so they match {@see \pocketmine\lang\Language::getLang()} of the server.
     * Where several tags share a code, {@see LocaleConverter::convertCode()} returns the first one listed.
     *
     * I created this mapping data by referring to the dataset on the site below.
     * @link http://github.com/datasets/language-codes/blob/d8f5a13/data/language-codes-3b2.csv
     */
    public const LANGUAGES_MAP = [
        "en_US" => "eng", //English (US)
        "en_GB" => "eng", //English (UK)
        "de_DE" => "deu", //Deutsch (Deutschland)
        "es_ES" => "spa", //Español (España)
        "es_MX" => "spa", //Español (México)
        "fr_FR" => "fra", //Français (France)
        "fr_CA" => "fra", //Français (Canada)
        "it_IT" => "ita", //Italiano (Italia)
        "ja_JP" => "jpn", //日本語 (日本)
        "ko_KR" => "kor", //한국어 (대한민국)
        "pt_BR" => "por", //Português (Brasil)
        "pt_PT" => "por", //Português (Portugal)
        "ru_RU" => "rus", //Русский (Россия)
        "zh_CN" => "chs", //简体中文
        "zh_TW" => "chs", //繁體中文 (PocketMine ships no Traditional Chinese file, so it falls back to Simplified)
        "nl_NL" => "nld", //Nederlands (Nederland)
        "bg_BG" => "bul", //Български (BG)
        "cs_CZ" => "cze", //Čeština (Česká republika)
        "da_DK" => "dan", //Dansk (DA)
        "el_GR" => "gre", //Ελληνικά (Ελλάδα)
        "fi_FI" => "fin", //Suomi (Suomi)
        "hu_HU" => "hun", //Magyar (HU)
        "id_ID" => "ind", //Bahasa Indonesia (Indonesia)
        "nb_NO" => "nor", //Norsk bokmål (Norge)
        "pl_PL" => "pol", //Polski (PL)
        "sk_SK" => "slo", //Slovensky (SK)
        "sv_SE" => "swe", //Svenska (Sverige)
        "tr_TR" => "tur", //Türkçe (Türkiye)
        "uk_UA" => "ukr", //Українська (Україна)
        "lv_LV" => "lav", //Latviešu (Latvija)
        "vi_VN" => "vie", //Tiếng Việt (Việt Nam)
    ];

    /**
     * Previously used codes that differ from PocketMine's language file names (current code => legacy code).
     * Translator falls back to the legacy code when a language of the current code is not registered.
     *
     * @var array<string, string> current code => legacy code
     */
    public const LEGACY_ALIASES = [
        "deu" => "ger",
        "fra" => "fre",
    ];

    /**
     * Convert IETF language tag to ISO 639-3 code
     *
     * @param string $locale The locale code in IETF format. ex) `en_US`
     *
     * @return string|null the locale code in ISO 639-3 format. ex) `eng`
     */
    public static function convertIETF(string $locale) : ?string{
        return self::LANGUAGES_MAP[$locale] ?? null;
    }

    /**
     * Convert IETF language tag to ISO 639-3 code
     *
     * @deprecated Use {@see LocaleConverter::convertIETF()} instead (correct spelling)
     * @param string $locale The locale code in IETF format. ex) `en_US`
     *
     * @return string|null the locale code in ISO 639-3 format. ex) `eng`
     */
    public static function convertIEFT(string $locale) : ?string{
        return self::convertIETF($locale);
    }

    /**
     * Convert ISO 639-3 code to IETF language tag
     *
     * @param string $locale the locale code in ISO 639-3 format. ex) `eng`
     *
     * @return string|null The locale code in IETF format. ex) `en_US`
     */
    public static function convertCode(string $locale) : ?string{
        /** @var array<string, string>|null $flippedMap */
        static $flippedMap = null;
        if($flippedMap === null){
            // array_flip() keeps the last key of duplicated values, but the first listed tag is the primary one
            $flippedMap = array_flip(array_reverse(self::LANGUAGES_MAP, true));
        }

        return $flippedMap[$locale] ?? null;
    }
}
