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
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author  Blugin team
 * @link    https://github.com/Blugin
 * @license https://www.gnu.org/licenses/lgpl-3.0 LGPL-3.0 License
 *
 *   (\ /)
 *  ( . .) ♥
 *  c(")(")
 */

declare(strict_types=1);

namespace blugin\lib\translator;

use pocketmine\plugin\PluginBase;

/**
 * This trait override most methods in the {@link PluginBase} abstract class.
 */
trait MultilingualConfigTrait{
    /**
     * @Override for multilingual support of the config file
     *
     * @return bool
     */
    public function saveDefaultConfig() : bool{
        $configFile = "{$this->getDataFolder()}config.yml";
        if(file_exists($configFile))
            return false;

        $resource = $this->getResource("locale/{$this->getServer()->getLanguage()->getLang()}.yml");
        if($resource === null){
            foreach($this->getResources() as $filePath => $info){
                if(preg_match('/^locale\/[a-zA-Z]{3}\.yml$/', $filePath)){
                    $resource = $this->getResource($filePath);
                    break;
                }
            }
        }
        if($resource === null)
            return false;

        $ret = stream_copy_to_stream($resource, $fp = fopen($configFile, "wb")) > 0;
        fclose($fp);
        fclose($resource);
        return $ret;
    }
}