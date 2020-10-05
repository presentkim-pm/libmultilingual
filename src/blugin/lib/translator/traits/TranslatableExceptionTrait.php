<?php

/*
 *
 *  ____  _             _         _____
 * | __ )| |_   _  __ _(_)_ __   |_   _|__  __ _ _ __ ___
 * |  _ \| | | | |/ _` | | '_ \    | |/ _ \/ _` | '_ ` _ \
 * | |_) | | |_| | (_| | | | | |   | |  __/ (_| | | | | | |
 * |____/|_|\__,_|\__, |_|_| |_|   |_|\___|\__,_|_| |_| |_|
 *                |___/
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the MIT License.
 *
 * @author  Blugin team
 * @link    https://github.com/Blugin
 * @license https://www.gnu.org/licenses/mit MIT License
 *
 *   (\ /)
 *  ( . .) ♥
 *  c(")(")
 */

declare(strict_types=1);

namespace blugin\lib\translator\traits;

use blugin\lib\translator\Translator;
use blugin\lib\translator\TranslatorHolder;

/**
 * This trait override most methods in the {@link \Exception} class.
 */
trait TranslatableExceptionTrait{
    /**
     * @link https://php.net/manual/en/exception.construct.php
     *
     * @param TranslatorHolder|Translator $translatorHolder
     * @param string                      $str original string
     * @param mixed[]                     $params translate parameters
     * @param int                         $code [optional] The Exception code.
     * @param \Throwable                  $previous [optional] The previous throwable used for the exception chaining.
     */
    public function __construct($translator, string $str, array $params = [], int $code = 0, \Throwable $previous = null){
        if($translator instanceof TranslatorHolder){
            $translator = $translator->getTranslator();
        }elseif(!$translator instanceof Translator){
            throw new \RuntimeException("Argument 1 passed must be of the " . TranslatorHolder::class . " or " . Translator::class . ", " . gettype($translator) . " given");
        }
        parent::__construct($translator->translate($str, $params), $code, $previous);
    }
}