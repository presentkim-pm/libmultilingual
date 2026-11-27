<?php

declare(strict_types=1);

namespace kim\present\libmultilingual\tests\traits;

use kim\present\libmultilingual\tests\TestCase;
use kim\present\libmultilingual\traits\MultilingualPluginTrait;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;

#[CoversNothing]
final class TraitsTest extends TestCase{

    private string $resources;
    private string $data;

    protected function setUp() : void{
        $base = $this->createTempDir();
        $this->resources = $base . "/res";
        $this->data = $base . "/data";
        mkdir($this->resources . "/locale", 0777, true);
        mkdir($this->resources . "/config", 0777, true);
        mkdir($this->data, 0777, true);
        file_put_contents($this->resources . "/locale/eng.ini", "language.name = English\nhello = Hello {%0}\n");
        file_put_contents($this->resources . "/locale/kor.ini", "language.name = 한국어\nhello = 안녕 {%0}\n");
        file_put_contents($this->resources . "/locale/notalocale.ini", "x = y\n");
        file_put_contents($this->resources . "/config/eng.yml", "lang: eng\n");
        file_put_contents($this->resources . "/config/kor.yml", "lang: kor\n");
    }

    #[Test]
    public function modifiableTraitLoadsFromDataFolder() : void{
        $plugin = new FakePlugin($this->resources, $this->data);
        self::assertSame("Hello A", $plugin->translate("hello", ["A"]));
        self::assertSame("안녕 A", $plugin->translate("hello", ["A"], "kor"));
        self::assertSame(["eng", "kor"], $this->sorted($plugin->getLocaleList()));
        self::assertFileExists($this->data . "/locale/eng.ini");
        self::assertFileDoesNotExist($this->data . "/locale/notalocale.ini");
    }

    #[Test]
    public function userEditsInDataFolderWinButFallbackComesFromResources() : void{
        $plugin = new FakePlugin($this->resources, $this->data);
        $plugin->getTranslator();
        file_put_contents($this->data . "/locale/kor.ini", "hello = Edited {%0}\n");
        file_put_contents($this->data . "/locale/eng.ini", "broken = 1\n");

        $fresh = new FakePlugin($this->resources, $this->data);
        self::assertSame("Edited A", $fresh->translate("hello", ["A"], "kor"));
        self::assertSame("eng", $fresh->getFallbackLanguage()->getLocale());
        self::assertSame("Hello {%0}", $fresh->getFallbackLanguage()->get("hello"));
        self::assertSame("English", $fresh->getFallbackLanguage()->getName());
    }

    #[Test]
    public function resourceOnlyTraitLoadsFromResources() : void{
        $plugin = new class($this->resources) {
            use MultilingualPluginTrait;

            public function __construct(private string $dir){}

            public function getResourcePath(string $f) : string{ return $this->dir . "/" . $f; }

            /** @return array<string, \SplFileInfo> */
            public function getResources() : array{
                return (new FakePlugin($this->dir, $this->dir))->getResources();
            }
        };
        self::assertSame("Hello A", $plugin->translate("hello", ["A"]));
        self::assertSame("안녕 A", $plugin->translate("hello", ["A"], "kor"));
    }

    #[Test]
    public function missingDataLocaleDirectoryThrows() : void{
        $plugin = new FakePlugin($this->resources, $this->data);
        // nothing to copy: remove all locale resources, so no data/locale directory is created
        foreach(glob($this->resources . "/locale/*") ?: [] as $f){
            unlink($f);
        }
        $this->expectException(\RuntimeException::class);
        $plugin->getTranslator();
    }

    #[Test]
    public function configIsLocalizedByServerLanguage() : void{
        $plugin = new FakePlugin($this->resources, $this->data);
        $plugin->serverLang = "kor";
        self::assertTrue($plugin->saveDefaultConfig());
        self::assertSame("lang: kor\n", file_get_contents($this->data . "/config.yml"));
        self::assertFalse($plugin->saveDefaultConfig());
    }

    #[Test]
    public function configFallsBackToEnglish() : void{
        $plugin = new FakePlugin($this->resources, $this->data);
        $plugin->serverLang = "xyz";
        self::assertTrue($plugin->saveResourceByLanguage("sub/dir/config.yml", "config/%s.yml"));
        self::assertSame("lang: eng\n", file_get_contents($this->data . "/sub/dir/config.yml"));
        self::assertFalse($plugin->saveResourceByLanguage("sub/dir/config.yml", "config/%s.yml"));
        self::assertTrue($plugin->saveResourceByLanguage("sub/dir/config.yml", "config/%s.yml", true));
        self::assertFalse($plugin->saveResourceByLanguage("other.yml", "missing/%s.yml"));
    }

    /**
     * @param string[] $list
     * @return string[]
     */
    private function sorted(array $list) : array{
        sort($list);
        return $list;
    }
}
