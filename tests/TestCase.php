<?php

declare(strict_types=1);

namespace kim\present\libmultilingual\tests;

use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase{

    /** @var string[] */
    private array $tempDirs = [];

    protected function createTempDir() : string{
        $dir = sys_get_temp_dir() . "/libmultilingual-test-" . bin2hex(random_bytes(6));
        mkdir($dir, 0777, true);
        return $this->tempDirs[] = $dir;
    }

    protected function tearDown() : void{
        foreach($this->tempDirs as $dir){
            $this->removeDir($dir);
        }
        $this->tempDirs = [];
    }

    private function removeDir(string $dir) : void{
        if(!is_dir($dir)){
            return;
        }
        foreach(scandir($dir) ?: [] as $name){
            if($name === "." || $name === ".."){
                continue;
            }
            $path = $dir . "/" . $name;
            is_dir($path) ? $this->removeDir($path) : unlink($path);
        }
        rmdir($dir);
    }
}
