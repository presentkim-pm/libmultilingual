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
 * @noinspection PhpUndefinedClassInspection
 */

declare(strict_types=1);

namespace kim\present\lib\translator\traits;

use kim\present\lib\translator\Translator;
use kim\present\lib\translator\TranslatorHolder;

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