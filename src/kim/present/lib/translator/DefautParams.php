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

namespace kim\present\lib\translator;

/**
 * @url https://github.com/PresentKim/libtranslator/blob/main/doc/eng/DefaultParams.md
 */
interface DefautParams{
    public const DEFAULT_PARAMS = [
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
        "left-mouse" => "\u{E060}",
        "right-mouse" => "\u{E061}",
        "middle-mouse" => "\u{E062}",
        "forward-arrow" => "\u{E080}",
        "left-arrow" => "\u{E081}",
        "down-arrow" => "\u{E082}",
        "right-arrow" => "\u{E083}",
        "jump-button" => "\u{E084}",
        "crouch-button" => "\u{E085}",
        "fly-up-button" => "\u{E086}",
        "fly-down-button" => "\u{E087}",
        "craftable-on" => "\u{E0A0}",
        "craftable-off" => "\u{E0A1}",
        "food" => "\u{E100}",
        "armour" => "\u{E101}",
        "minecoin" => "\u{E102}",
        "code-builder" => "\u{E103}",
        "immersive-reader-button" => "\u{E104}",
        "token" => "\u{E105}",
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
        "rift-y" => "\u{E0EA}"
    ];
}