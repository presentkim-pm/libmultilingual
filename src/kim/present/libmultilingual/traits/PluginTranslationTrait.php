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

namespace kim\present\libmultilingual\traits;

use kim\present\libmultilingual\Language;
use kim\present\libmultilingual\Translator;
use pocketmine\plugin\PluginBase;

/**
 * This trait implements the {@link TranslatorHolder} interface.
 * Automatically create translators from {@link PluginBase} resources.
 */
trait PluginTranslationTrait{
    use TranslatorHolderTrait;

    public function getTranslator() : Translator{
        $this->translator ??= $this->initTranslator();

        return $this->translator;
    }

    /**
     * Returns the base path (relative to plugin resources) where locale files are stored.
     *
     * @return string Resource path without leading or trailing slash. Example: "locale"
     */
    protected function getLocaleResourcePath() : string{
        return "locale";
    }

    /**
     * Returns the regex pattern used to match locale file names.
     * The first capturing group must be the locale code.
     *
     * @return string PCRE pattern. Example: "/^([a-zA-Z]{3})\.ini$/"
     */
    protected function getLocaleFilePattern() : string{
        return "/^([a-zA-Z]{3})\.ini$/";
    }

    /**
     * Generate a new translator instance from the language files of plugin resources.
     *
     * @return Translator
     */
    private function initTranslator() : Translator{
        /** @var PluginBase $this */
        $languages = [];

        $basePath = rtrim($this->getLocaleResourcePath(), "/") . "/";
        foreach($this->getResources() as $filePath => $info){
            if(!str_starts_with($filePath, $basePath)){
                continue;
            }

            $relativePath = substr($filePath, strlen($basePath));
            if(preg_match($this->getLocaleFilePattern(), $relativePath, $matches)){
                $resourcePath = $this->getResourcePath($filePath);
                $language = Language::fromFile($resourcePath, $matches[1]);
                if($language !== null){
                    $languages[$matches[1]] = $language;
                }
            }
        }
        return new Translator($languages);
    }
}
