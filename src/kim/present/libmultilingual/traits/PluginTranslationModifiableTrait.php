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
        foreach($this->getResources() as $filePath => $info){
            if(preg_match('/^locale\/[a-zA-Z]{3}\.ini$/', $filePath)){
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

        $path = $this->getDataFolder() . "locale/";
        if(!is_dir($path)){
            throw new RuntimeException("Language directory $path does not exist or is not a directory");
        }

        foreach(scandir($path, SCANDIR_SORT_NONE) as $filename){
            if(preg_match("/^([a-zA-Z]{3})\.ini$/", $filename, $matches) || !isset($matches[1])){
                $languages[$matches[1]] = Language::fromFile($path . $filename, $matches[1]);
            }
        }
        return $languages;
    }

    /** Load fallback language from plugin resources */
    private function loadFallbackLanguage() : ?Language{
        /** @var PluginBase $this */
        $locale = $this->getServer()->getLanguage()->getLang();
        $resourcePath = $this->getResourcePath("locale/" . PMLanguage::FALLBACK_LANGUAGE . ".ini");
        if(file_exists($resourcePath)){
            $contents = file_get_contents($resourcePath);
            return Language::fromContents($contents, strtolower($locale));
        }

        return null;
    }
}