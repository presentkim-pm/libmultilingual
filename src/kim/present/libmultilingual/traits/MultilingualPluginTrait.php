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

use kim\present\libmultilingual\TranslatorHolder;

/**
 * One-trait entry point for plugin multilingual support.
 *
 * Combines {@link PluginTranslationTrait} and {@link DelegatedTranslatorHolderTrait}
 * so that a single `use` provides both translator creation and delegation methods.
 *
 * Use this when you want the simplest setup: add the trait and call
 * {@see TranslatorHolder::getTranslator()} or {@see DelegatedTranslatorHolderTrait::translate()}
 * directly on your plugin.
 *
 * @see PluginTranslationTrait
 * @see DelegatedTranslatorHolderTrait
 * @see MultilingualPluginModifiableTrait For user-modifiable messages from data folder
 */
trait MultilingualPluginTrait{
    use PluginTranslationTrait, DelegatedTranslatorHolderTrait{
        PluginTranslationTrait::getTranslator insteadof DelegatedTranslatorHolderTrait;
    }
}
