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
use kim\present\libmultilingual\Translator;
use pocketmine\command\CommandSender;
use pocketmine\lang\Language as PMLanguage;
use pocketmine\plugin\PluginBase;
use RuntimeException;
use Stringable;

use function fclose;
use function is_dir;
use function preg_match;
use function scandir;
use function stream_get_contents;
use function strtolower;

/**
 * This trait override most methods in the {@link PluginBase} abstract class.
 *
 * @see https://github.com/presentkim-pm/libmultilingual/blob/main/README.md#sparkles-quick-use-via-translatableplugintrait
 */
trait TranslatablePluginTrait{
    use TranslatorHolderTrait;

    public function getTranslator() : Translator{
        /** @var PluginBase|TranslatablePluginTrait $this */
        if(empty($this->translator)){
            $this->saveDefaultLanguages();
            $this->translator = new Translator($this->loadLanguages(), $this->loadFallbackLanguage());
        }

        return $this->translator;
    }

    /** Save default language resources */
    private function saveDefaultLanguages() : void{
        /** @var PluginBase|TranslatablePluginTrait $this */
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
        /** @var PluginBase|TranslatablePluginTrait $this */
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

    /**
     * @param string                         $str original string
     * @param string[]|Stringable[]|number[] $params translate parameters
     * @param string|CommandSender|null      $locale translate language locale or translate target. if null, translate by default language
     *
     * @return string the translated string
     */
    public function translate(string $str, array $params = [], string|CommandSender|null $locale = null) : string{
        return $this->getTranslator()->translate($str, $params, $locale);
    }

    /** Load fallback language from plugin resources */
    private function loadFallbackLanguage() : ?Language{
        /** @var PluginBase|TranslatablePluginTrait $this */
        $locale = $this->getServer()->getLanguage()->getLang();
        $resource = $this->getResource("locale/" . PMLanguage::FALLBACK_LANGUAGE . ".ini");
        if($resource !== null){
            $contents = stream_get_contents($resource);
            fclose($resource);
            return Language::fromContents($contents, strtolower($locale));
        }

        return null;
    }
}