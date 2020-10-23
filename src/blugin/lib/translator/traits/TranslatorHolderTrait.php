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

namespace blugin\lib\translator\traits;

use blugin\lib\translator\Translator;
use pocketmine\plugin\PluginBase;

/**
 * This trait override most methods in the {@link PluginBase} abstract class.
 */
trait TranslatorHolderTrait{
    /** @var Translator */
    private $translator;

    public function getTranslator() : Translator{
        return $this->translator;
    }

    /**
     * Load language with save default language resources
     */
    public function loadLanguage(?string $locale = null) : void{
        $this->saveDefaultLocales();

        /** @noinspection PhpParamsInspection */
        $this->translator = new Translator($this);
        if($locale !== null){
            $this->translator->setDefaultLocale($locale);
        }
    }

    /**
     * Save default language resources
     */
    public function saveDefaultLocales(){
        foreach($this->getResources() as $filePath => $info){
            if(preg_match('/^locale\/[a-zA-Z]{3}\.ini$/', $filePath)){
                $this->saveResource($filePath);
            }
        }
    }
}