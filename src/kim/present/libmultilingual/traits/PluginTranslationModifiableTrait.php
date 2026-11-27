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
use pocketmine\lang\Language as PMLanguage;
use pocketmine\plugin\PluginBase;
use RuntimeException;

/**
 * This trait implements the {@link TranslatorHolder} interface.
 * Automatically create translators from {@link PluginBase} data folder.
 * Since it is imported from the data folder, the user can modify the message.
 *
 * However, the fallback language is created from the 'eng.ini' of the resource.
 * Because problems may occur due to plugin updates or incorrect modifying by users.
 */
trait PluginTranslationModifiableTrait{
    use PluginTranslationTrait;

    /**
     * Generate a new translator instance from the language files of plugin data folder.
     *
     * @return Translator
     *
     * @noinspection PhpUnusedPrivateMethodInspection
     */
    private function initTranslator() : Translator{
        $this->saveDefaultLanguages();
        return new Translator($this->loadLanguages(), $this->loadFallbackLanguage());
    }

    /** Save default language resources */
    private function saveDefaultLanguages() : void{
        /** @var PluginBase $this */
        $basePath = trim(str_replace("\\", "/", $this->getLocaleResourcePath()), "/") . "/";
        foreach($this->getResources() as $filePath => $info){
            $filePath = str_replace("\\", "/", (string) $filePath);
            if(!str_starts_with($filePath, $basePath)){
                continue;
            }

            $relativePath = substr($filePath, strlen($basePath));
            if(preg_match($this->getLocaleFilePattern(), $relativePath)){
                $this->saveResource($filePath);
            }
        }
    }

    /**
     * Load all locale file from plugin data folder
     *
     * @return Language[]
     */
    private function loadLanguages() : array{
        /** @var PluginBase $this */
        $languages = [];

        $localePath = trim(str_replace("\\", "/", $this->getLocaleResourcePath()), "/");
        $path = rtrim($this->getDataFolder(), "/\\") . "/" . $localePath . "/";
        if(!is_dir($path)){
            throw new RuntimeException("Language directory $path does not exist or is not a directory");
        }

        $filenames = scandir($path, SCANDIR_SORT_NONE);
        if($filenames === false){
            throw new RuntimeException("Failed to read language directory $path");
        }

        foreach($filenames as $filename){
            if(preg_match($this->getLocaleFilePattern(), $filename, $matches)){
                $language = Language::fromFile($path . $filename, $matches[1]);
                if($language !== null){
                    $languages[$matches[1]] = $language;
                }
            }
        }
        return $languages;
    }

    /** Load fallback language from plugin resources */
    private function loadFallbackLanguage() : ?Language{
        /** @var PluginBase $this */
        $resourceBasePath = trim(str_replace("\\", "/", $this->getLocaleResourcePath()), "/");
        foreach($this->getResources() as $filePath => $info){
            $filePath = str_replace("\\", "/", (string) $filePath);
            if(
                str_starts_with($filePath, $resourceBasePath . "/") &&
                preg_match($this->getLocaleFilePattern(), substr($filePath, strlen($resourceBasePath) + 1), $matches) &&
                strtolower($matches[1]) === PMLanguage::FALLBACK_LANGUAGE
            ){
                return Language::fromFile($this->getResourcePath($filePath), PMLanguage::FALLBACK_LANGUAGE);
            }
        }

        return null;
    }
}
