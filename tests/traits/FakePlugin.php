<?php

declare(strict_types=1);

namespace kim\present\libmultilingual\tests\traits;

use kim\present\libmultilingual\TranslatorHolder;
use kim\present\libmultilingual\traits\MultilingualConfigTrait;
use kim\present\libmultilingual\traits\MultilingualPluginModifiableTrait;

/**
 * A minimal stand-in for PluginBase providing only the methods the traits rely on.
 * Resources live in $resourceDir, the data folder in $dataDir.
 */
class FakePlugin implements TranslatorHolder{
    use MultilingualPluginModifiableTrait;
    use MultilingualConfigTrait;

    public string $serverLang = "eng";

    public function __construct(private string $resourceDir, private string $dataDir){}

    public function getDataFolder() : string{
        return $this->dataDir . "/";
    }

    public function getResourcePath(string $filename) : string{
        return $this->resourceDir . "/" . $filename;
    }

    /** @return array<string, \SplFileInfo> */
    public function getResources() : array{
        $resources = [];
        $prefix = $this->resourceDir . "/";
        foreach(new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($prefix, \FilesystemIterator::SKIP_DOTS)) as $file){
            if($file->isFile()){
                $resources[substr((string) $file, strlen($prefix))] = $file;
            }
        }
        return $resources;
    }

    public function saveResource(string $filename, bool $replace = false) : bool{
        $out = $this->dataDir . "/" . $filename;
        if(!$replace && file_exists($out)){
            return false;
        }
        @mkdir(dirname($out), 0777, true);
        return copy($this->resourceDir . "/" . $filename, $out);
    }

    public function getServer() : object{
        $lang = $this->serverLang;
        return new class($lang){
            public function __construct(private string $lang){}

            public function getLanguage() : object{
                $lang = $this->lang;
                return new class($lang){
                    public function __construct(private string $lang){}

                    public function getLang() : string{ return $this->lang; }
                };
            }
        };
    }
}
