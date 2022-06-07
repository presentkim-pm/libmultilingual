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

use pocketmine\plugin\PluginBase;

/** This trait override most methods in the {@link PluginBase} abstract class. */
trait MultilingualConfigTrait{
    use MultilingualResourceTrait;

    /**
     * @override to multilingual support of the config file
     * @see PluginBase::saveDefaultConfig()
     */
    public function saveDefaultConfig() : bool{
        /** @var PluginBase $this */
        return $this->saveResourceByLanguage("config.yml", "config/%s.yml");
    }
}