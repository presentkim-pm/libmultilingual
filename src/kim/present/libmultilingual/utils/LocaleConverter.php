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
 * @noinspection SpellCheckingInspection
 * @noinspection PhpUnused
 */

declare(strict_types=1);

namespace kim\present\libmultilingual\utils;

use function array_flip;

final class LocaleConverter{
    private function __construct(){
    }

    /**
     * @var string[] IETF_language_tag => ISO_639-3 code
     *
     * @link https://en.wikipedia.org/wiki/IETF_language_tag
     * @link https://en.wikipedia.org/wiki/ISO_639-3
     *
     * The list was taken from language_names.json in the Minecraft resource.
     * @link https://github.com/ZtechNetwork/MCBVanillaResourcePack/blob/cd647b3/texts/language_names.json
     *
     * I created this mapping data by referring to the dataset on the site below.
     * @link http://github.com/datasets/language-codes/blob/d8f5a13/data/language-codes-3b2.csv
     */
    public const LANGUAGES_MAP = [
        "en_US" => "eng", //English (US)
        "en_GB" => "eng", //English (UK)
        "de_DE" => "ger", //Deutsch (Deutschland)
        "es_ES" => "spa", //Español (España)
        "es_MX" => "spa", //Español (México)
        "fr_FR" => "fre", //Français (France)
        "fr_CA" => "fre", //Français (Canada)
        "it_IT" => "ita", //Italiano (Italia)
        "ja_JP" => "jpn", //日本語 (日本)
        "ko_KR" => "kor", //한국어 (대한민국)
        "pt_BR" => "por", //Português (Brasil)
        "pt_PT" => "por", //Português (Portugal)
        "ru_RU" => "rus", //Русский (Россия)
        "zh_CN" => "chs", //简体中文
        "zh_TW" => "chs", //繁體中文
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
    ];

    /** @return string|null the locale name converted from IETF_language_tag to ISO_639-3 code */
    public static function convertIEFT(string $tag) : ?string{
        return self::LANGUAGES_MAP[$tag] ?? null;
    }

    /** @return string|null the locale name converted from ISO_639-3 code to IETF_language_tag */
    public static function convertCode(string $code) : ?string{
        static $flippedMap;
        if(empty($flippedMap)){
            $flippedMap = array_flip(self::LANGUAGES_MAP);
        }

        return $flippedMap[$code] ?? null;
    }
}