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
 * @noinspection PhpUnused
 */

declare(strict_types=1);

namespace kim\present\libmultilingual\traits;

use kim\present\libmultilingual\Language;
use kim\present\libmultilingual\TranslatorHolder;
use pocketmine\command\CommandSender;
use Stringable;

/** A trait that makes the {@link TranslatorHolder} implementation class to delegate the Translator method. */
trait DelegatedTranslatorHolderTrait{
    /**
     * @param string                          $str original string
     * @param array<string|Stringable|number> $params translate parameters
     * @param string|CommandSender|null       $locale translate language locale or translate target. if null, translate by default language
     *
     * @return string the translated string
     */
    public function translate(string $str, array $params = [], string|CommandSender|null $locale = null) : string{
        /** @var TranslatorHolder $this */
        return $this->getTranslator()->translate($str, $params, $locale);
    }

    /** @return Language[] */
    public function getLanguages() : array{
        /** @var TranslatorHolder $this */
        return $this->getTranslator()->getLanguages();
    }

    /** @return string[] */
    public function getLocaleList() : array{
        /** @var TranslatorHolder $this */
        return $this->getTranslator()->getLocaleList();
    }

    /** @return Language if $locale is null, return default language */
    public function getLanguage(?string $locale = null) : Language{
        /** @var TranslatorHolder $this */
        return $this->getTranslator()->getLanguage($locale);
    }

    public function getFallbackLanguage() : Language{
        /** @var TranslatorHolder $this */
        return $this->getTranslator()->getFallbackLanguage();
    }

    public function setFallbackLanguage(Language $fallbackLanguage) : void{
        /** @var TranslatorHolder $this */
        $this->getTranslator()->setFallbackLanguage($fallbackLanguage);
    }
}