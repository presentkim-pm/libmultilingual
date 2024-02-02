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

namespace kim\present\libmultilingual;

use function strtolower;

/**
 * This class manages the global parameters used for the Translator's translation.
 */
final class GlobalParams{
    private function __construct(){ }

    private const DEFAULTS = [
        "n" => "\n",
        "br" => "\n",
        "tab" => "\t",
        "t" => "\t",
        "xbox-a" => "\u{E000}",
        "xbox-b" => "\u{E001}",
        "xbox-x" => "\u{E002}",
        "xbox-y" => "\u{E003}",
        "xbox-lb" => "\u{E004}",
        "xbox-rb" => "\u{E005}",
        "xbox-lt" => "\u{E006}",
        "xbox-rt" => "\u{E007}",
        "xbox-select" => "\u{E008}",
        "xbox-start" => "\u{E009}",
        "xbox-ls" => "\u{E00A}",
        "xbox-rs" => "\u{E00B}",
        "xbox-d-up" => "\u{E00C}",
        "xbox-d-left" => "\u{E00D}",
        "xbox-d-down" => "\u{E00E}",
        "xbox-d-right" => "\u{E00F}",
        "xbox-a-bright" => "\u{E010}",
        "xbox-b-bright" => "\u{E011}",
        "xbox-x-bright" => "\u{E012}",
        "xbox-y-bright" => "\u{E013}",
        "jump" => "\u{E014}",
        "attack" => "\u{E015}",
        "joystick" => "\u{E016}",
        "crosshair" => "\u{E017}",
        "interact" => "\u{E018}",
        "crouch" => "\u{E019}",
        "sprint" => "\u{E01A}",
        "fly-up" => "\u{E01B}",
        "fly-down" => "\u{E01C}",
        "dismount" => "\u{E01D}",
        // U+E01E - U+E01F
        "ps-x" => "\u{E020}",
        "ps-o" => "\u{E021}",
        "ps-square" => "\u{E022}",
        "ps-triangle" => "\u{E023}",
        "ps-l1" => "\u{E024}",
        "ps-r1" => "\u{E025}",
        "ps-l2" => "\u{E026}",
        "ps-r2" => "\u{E027}",
        "ps-select" => "\u{E028}",
        "ps-start" => "\u{E029}",
        "ps-l3" => "\u{E02A}",
        "ps-r3" => "\u{E02B}",
        "ps-d-up" => "\u{E02C}",
        "ps-d-left" => "\u{E02D}",
        "ps-d-down" => "\u{E02E}",
        "ps-d-right" => "\u{E02F}",
        // U+E030 - U+E03F
        "nintendo-a" => "\u{E040}",
        "nintendo-b" => "\u{E041}",
        "nintendo-x" => "\u{E042}",
        "nintendo-y" => "\u{E043}",
        "nintendo-l" => "\u{E044}",
        "nintendo-r" => "\u{E045}",
        "nintendo-zl" => "\u{E046}",
        "nintendo-zr" => "\u{E047}",
        "nintendo-minus" => "\u{E048}",
        "nintendo-plus" => "\u{E049}",
        "nintendo-ls" => "\u{E04A}",
        "nintendo-rs" => "\u{E04B}",
        "nintendo-d-up" => "\u{E04C}",
        "nintendo-d-left" => "\u{E04D}",
        "nintendo-d-down" => "\u{E04E}",
        "nintendo-d-right" => "\u{E04F}",
        // U+E050 - U+E05F
        "left-mouse" => "\u{E060}",
        "right-mouse" => "\u{E061}",
        "middle-mouse" => "\u{E062}",
        "mouse" => "\u{E063}",
        // U+E064
        "forward-arrow-new" => "\u{E065}",
        "left-arrow-new" => "\u{E066}",
        "down-arrow-new" => "\u{E067}",
        "right-arrow-new" => "\u{E068}",
        "jump-button-new" => "\u{E069}",
        "crouch-button-new" => "\u{E06A}",
        "inventory-button" => "\u{E06B}",
        "fly-up-button-new" => "\u{E06C}",
        "fly-down-button-new" => "\u{E06D}",
        // U+E06E - U+E06F
        "left-mouse-new" => "\u{E070}",
        "right-mouse-new" => "\u{E071}",
        "middle-mouse-new" => "\u{E072}",
        "mouse-new" => "\u{E073}",
        // U+E074 - U+E07F
        "forward-arrow-arrow" => "\u{E080}",
        "left-arrow" => "\u{E081}",
        "down-arrow" => "\u{E082}",
        "right-arrow" => "\u{E083}",
        "jump-button" => "\u{E084}",
        "crouch-button" => "\u{E085}",
        "fly-up-button" => "\u{E086}",
        "fly-down-button" => "\u{E087}",
        // U+E088 - U+E09F
        "craftable-on" => "\u{E0A0}",
        "craftable-off" => "\u{E0A1}",
        // U+E0A2 - U+E0BF
        "mr-lg" => "\u{E0C0}",
        "mr-rg" => "\u{E0C1}",
        "mr-menu" => "\u{E0C2}",
        "mr-ls" => "\u{E0C3}",
        "mr-rs" => "\u{E0C4}",
        "mr-left-touchpad" => "\u{E0C5}",
        "mr-left-touchpad-horizontal" => "\u{E0C6}",
        "mr-left-touchpad-vertical" => "\u{E0C7}",
        "mr-right-touchpad" => "\u{E0C8}",
        "mr-right-touchpad-horizontal" => "\u{E0C9}",
        "mr-right-touchpad-vertical" => "\u{E0CA}",
        "mr-lt" => "\u{E0CB}",
        "mr-rt" => "\u{E0CC}",
        "mr-windows" => "\u{E0CD}",
        // U+E0CE - U+E0DF
        "rift-zero" => "\u{E0E0}",
        "rift-a" => "\u{E0E1}",
        "rift-b" => "\u{E0E2}",
        "rift-lg" => "\u{E0E3}",
        "rift-rg" => "\u{E0E4}",
        "rift-ls" => "\u{E0E5}",
        "rift-rs" => "\u{E0E6}",
        "rift-lt" => "\u{E0E7}",
        "rift-rt" => "\u{E0E8}",
        "rift-x" => "\u{E0E9}",
        "rift-y" => "\u{E0EA}",
        // U+E0EB - U+E0FF
        "food" => "\u{E100}",
        "armour" => "\u{E101}",
        "minecoin" => "\u{E102}",
        "code-builder" => "\u{E103}",
        "immersive-reader-button" => "\u{E104}",
        "token" => "\u{E105}",
        "hollow-star" => "\u{E106}",
        "solid-star" => "\u{E107}",
        "wooden-pickaxe" => "\u{E108}",
        "wooden-sword" => "\u{E109}",
        "crafting-table" => "\u{E10A}",
        "furnace" => "\u{E10B}",
        "heart" => "\u{E10C}"
    ];

    /** @var string[] The list of global translate parameters */
    private static array $params = self::DEFAULTS;

    /** @return array<string, string> The list of global translate parameters */
    public static function getAll() : array{
        return self::$params;
    }

    /**
     * Sets a global translate parameter
     *
     * @param string $paramName The parameter name
     * @param string $contents The parameter's replacement contents
     */
    public static function set(string $paramName, string $contents) : void{
        self::$params[strtolower($paramName)] = $contents;
    }

    /**
     * Removes a global translate parameter
     *
     * @param string $paramName The parameter name
     */
    public static function remove(string $paramName) : void{
        unset(self::$params[strtolower($paramName)]);
    }
}