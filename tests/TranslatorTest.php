<?php

declare(strict_types=1);

namespace kim\present\libmultilingual\tests;

use kim\present\libmultilingual\GlobalParams;
use kim\present\libmultilingual\Language;
use kim\present\libmultilingual\Translator;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use RuntimeException;

#[CoversClass(Translator::class)]
final class TranslatorTest extends TestCase{

    private Translator $translator;

    protected function setUp() : void{
        $this->translator = new Translator([
            new Language([
                "language.name" => "English",
                "hello" => "Hello",
                "greet" => "Hi {%0}, you are {%1}",
                "named" => "Name: {%name}!",
                "onlyEng" => "Only English",
                "nl" => "a{%n}b",
            ], "eng"),
            new Language(["language.name" => "한국어", "hello" => "안녕", "greet" => "{%0}님, {%1}"], "kor"),
        ]);
    }

    protected function tearDown() : void{
        GlobalParams::remove("custom");
        parent::tearDown();
    }

    #[Test]
    public function constructorWithoutFallbackThrows() : void{
        $this->expectException(RuntimeException::class);
        new Translator([new Language([], "kor")]);
    }

    #[Test]
    public function constructorAcceptsExplicitFallback() : void{
        $fallback = new Language(["a" => "A"], "kor");
        $translator = new Translator([], $fallback);
        self::assertSame($fallback, $translator->getFallbackLanguage());
        self::assertSame("A", $translator->translate("a"));
    }

    #[Test]
    public function lookupAndFallback() : void{
        self::assertSame("Hello", $this->translator->translate("hello"));
        self::assertSame("안녕", $this->translator->translate("hello", [], "kor"));
        self::assertSame("안녕", $this->translator->translate("hello", [], "KOR"));
        self::assertSame("Only English", $this->translator->translate("onlyEng", [], "kor"));
        self::assertSame("Hello", $this->translator->translate("hello", [], "xyz"));
        self::assertSame("unknown.key", $this->translator->translate("unknown.key"));
    }

    #[Test]
    public function percentKeysInMixedText() : void{
        self::assertSame("Say Hello now", $this->translator->translate("Say %hello% now"));
        self::assertSame("Hello Hello", $this->translator->translate("%hello% %hello%"));
        self::assertSame("100% sure", $this->translator->translate("100% sure"));
    }

    #[Test]
    public function positionalAndNamedParams() : void{
        self::assertSame("Hi Bob, you are 3", $this->translator->translate("greet", ["Bob", 3]));
        self::assertSame("Bob님, 3", $this->translator->translate("greet", ["Bob", 3], "kor"));
        self::assertSame("Name: Al!", $this->translator->translate("named", ["name" => "Al"]));
        self::assertSame("Name: {%name}!", $this->translator->translate("named"));
        self::assertSame("x1y", $this->translator->translate("x{%0}y", [1]));
    }

    #[Test]
    public function globalParams() : void{
        self::assertSame("a\nb", $this->translator->translate("nl"));
        GlobalParams::set("custom", "G");
        self::assertSame("G", $this->translator->translate("{%custom}"));
    }

    #[Test]
    public function callerParamsOverrideGlobalsAndKeepNumericKeys() : void{
        GlobalParams::set("custom", "G");
        self::assertSame("C", $this->translator->translate("{%custom}", ["custom" => "C"]));
        self::assertSame("X|Y", $this->translator->translate("{%n}", ["n" => "X"]) . "|Y");
        self::assertSame("a-b-c", $this->translator->translate("{%0}-{%1}-{%2}", ["a", "b", "c"]));
    }

    #[Test]
    public function replacedValuesAreNotScannedAgain() : void{
        self::assertSame("{%1} B", $this->translator->translate("{%0} {%1}", ["{%1}", "B"]));
    }

    /** @return array<string, array{string, string}> */
    public static function unicodeProvider() : array{
        return [
            "bmp" => ["{%u0041}", "A"],
            "hangul" => ["{%uAC00}", "가"],
            "short" => ["{%u41}", "A"],
            "odd length" => ["{%u041}", "A"],
            "emoji" => ["{%u1F600}", "\u{1F600}"],
            "max" => ["{%u10FFFF}", "\u{10FFFF}"],
            "lowercase hex" => ["{%u1f600}", "\u{1F600}"],
            "too large" => ["{%u110000}", "{%u110000}"],
            "surrogate" => ["{%uD800}", "{%uD800}"],
            "surrogate low" => ["{%uDFFF}", "{%uDFFF}"],
            "too long" => ["{%u00000041}", "{%u00000041}"],
            "not hex" => ["{%uZZ}", "{%uZZ}"],
            "bare u" => ["{%u}", "{%u}"],
        ];
    }

    #[Test]
    #[DataProvider("unicodeProvider")]
    public function unicodeParams(string $input, string $expected) : void{
        $previous = set_error_handler(static function(int $no, string $str) : never{
            throw new \ErrorException($str, 0, $no);
        });
        try{
            self::assertSame($expected, $this->translator->translate($input));
        }finally{
            restore_error_handler();
        }
        self::assertArrayNotHasKey("u0041", GlobalParams::getAll());
    }

    #[Test]
    public function explicitParamBeatsUnicodeDecoding() : void{
        self::assertSame("custom", $this->translator->translate("{%u0041}", ["u0041" => "custom"]));
    }

    #[Test]
    public function languageManagement() : void{
        self::assertSame(["eng", "kor"], $this->translator->getLocaleList());
        self::assertTrue($this->translator->hasKey("hello", "kor"));
        self::assertFalse($this->translator->hasKey("onlyEng", "kor"));

        $this->translator->addLanguage(new Language(["hello" => "Hallo"], "DEU"));
        self::assertSame("Hallo", $this->translator->translate("hello", [], "deu"));
        self::assertContains("deu", $this->translator->getLocaleList());

        $this->translator->removeLanguage("DEU");
        self::assertSame("Hello", $this->translator->translate("hello", [], "deu"));
        self::assertNotContains("deu", $this->translator->getLocaleList());
    }

    #[Test]
    public function withoutServerUsesFallbackLanguage() : void{
        self::assertSame($this->translator->getFallbackLanguage(), $this->translator->getLanguage());
        self::assertTrue($this->translator->hasKey("hello"));
        // a target object with a locale, but no running server
        $player = new class{
            public function getLocale() : string{ return "ko_KR"; }
        };
        self::assertSame("Hello", $this->translator->translate("hello", [], $player));
    }

    #[Test]
    public function setFallbackLanguage() : void{
        $this->translator->setFallbackLanguage(new Language(["hello" => "Fallback"], "kor"));
        self::assertSame("Fallback", $this->translator->translate("hello", [], "xyz"));
    }

    #[Test]
    public function legacyAliasLanguageIsFound() : void{
        $this->translator->addLanguage(new Language(["hello" => "Hallo"], "ger"));
        self::assertSame("Hallo", $this->translator->translate("hello", [], "deu"));
    }
}
