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
     * Generate a new translator instance from the language files of plugin resources.
     *
     * @return Translator
     */
    private function initTranslator() : Translator{
        /** @var PluginBase $this */
        $languages = [];

        foreach($this->getResources() as $filePath => $info){
            if(preg_match("/^locale\/[a-zA-Z]{3}\.ini$/", $filePath, $matches)){
                $resourcePath = $this->getResourcePath($filePath);
                $language = Language::fromFile($resourcePath, $matches[1]);

                $languages[$matches[1]] = $language;
                break;
            }
        }
        return new Translator($languages);
    }
}
