<?php

declare(strict_types=1);

namespace kim\present\libmultilingual\tests;

use kim\present\libmultilingual\Language;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

#[CoversClass(Language::class)]
final class LanguageTest extends TestCase{

    #[Test]
    public function parsesContents() : void{
        $lang = Language::fromContents("; comment\nlanguage.name = English\na.b = Hello {%0}\n", "ENG");
        self::assertSame("eng", $lang->getLocale());
        self::assertSame("English", $lang->getName());
        self::assertSame("Hello {%0}", $lang->get("a.b"));
        self::assertNull($lang->get("missing"));
        self::assertSame("missing", $lang->getNonNull("missing"));
    }

    #[Test]
    public function unescapesAndUnquotes() : void{
        $lang = Language::fromContents(
            "a = line1\\nline2\nb = \"  quoted  \"\nc = 'single'\nd = tab\\there\ne = \"semi; kept\"\nf = x ; comment\n",
            "eng"
        );
        self::assertSame("line1\nline2", $lang->get("a"));
        self::assertSame("  quoted  ", $lang->get("b"));
        self::assertSame("'single'", $lang->get("c"));
        self::assertSame("tab\there", $lang->get("d"));
        self::assertSame("semi; kept", $lang->get("e"));
        self::assertSame("x", $lang->get("f"));
    }

    #[Test]
    public function parsesResourceExample() : void{
        $lang = Language::fromFile(dirname(__DIR__) . "/resources-example/locale/eng.ini", "eng");
        self::assertNotNull($lang);
        self::assertSame("English", $lang->getName());
        self::assertSame("'{%0}' is not a valid number", $lang->get("commands.generic.num.invalid"));
        $kor = Language::fromFile(dirname(__DIR__) . "/resources-example/locale/kor.ini", "kor");
        self::assertSame("한국어", $kor?->getName());
    }

    /** @return array<string, array{string}> */
    public static function malformedProvider() : array{
        return [
            "unclosed section" => ["a=1\n[bad\nb=2"],
            "garbage" => ["=5\n{{{\n"],
            "empty" => [""],
        ];
    }

    #[Test]
    #[DataProvider("malformedProvider")]
    public function malformedContentsDoNotWarn(string $contents) : void{
        $previous = set_error_handler(static function(int $no, string $str) : never{
            throw new \ErrorException($str, 0, $no);
        });
        try{
            $lang = Language::fromContents($contents, "eng");
        }finally{
            restore_error_handler();
        }
        self::assertSame("eng", $lang->getLocale());
        self::assertNull($lang->get("bad"));
    }

    #[Test]
    public function ignoresSectionsAndArrayKeys() : void{
        $lang = Language::fromContents("a = 1\nb[x] = 2\n[sec]\nc = 3\n", "eng");
        self::assertSame("1", $lang->get("a"));
        self::assertNull($lang->get("b"));
    }

    #[Test]
    public function fromFileHandlesMissingFile() : void{
        $dir = $this->createTempDir();
        self::assertNull(Language::fromFile($dir . "/nope.ini", "eng"));
        self::assertNull(Language::fromFile($dir, "eng"));
        file_put_contents($dir . "/kor.ini", "language.name = 한국어\n");
        self::assertSame("한국어", Language::fromFile($dir . "/kor.ini", "kor")?->getName());
    }
}
