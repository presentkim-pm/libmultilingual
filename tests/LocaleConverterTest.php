<?php

declare(strict_types=1);

namespace kim\present\libmultilingual\tests;

use kim\present\libmultilingual\utils\LocaleConverter;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;

#[CoversClass(LocaleConverter::class)]
final class LocaleConverterTest extends TestCase{

    #[Test]
    public function convertsIetfToCode() : void{
        self::assertSame("eng", LocaleConverter::convertIETF("en_US"));
        self::assertSame("kor", LocaleConverter::convertIETF("ko_KR"));
        self::assertSame("deu", LocaleConverter::convertIETF("de_DE"));
        self::assertSame("fra", LocaleConverter::convertIETF("fr_FR"));
        self::assertSame("vie", LocaleConverter::convertIETF("vi_VN"));
        self::assertNull(LocaleConverter::convertIETF("xx_XX"));
        self::assertSame("eng", LocaleConverter::convertIEFT("en_GB"));
    }

    #[Test]
    public function convertsCodeToIetf() : void{
        self::assertSame("en_US", LocaleConverter::convertCode("eng"));
        self::assertSame("ko_KR", LocaleConverter::convertCode("kor"));
        self::assertSame("zh_CN", LocaleConverter::convertCode("chs"));
        self::assertSame("es_ES", LocaleConverter::convertCode("spa"));
        self::assertSame("pt_BR", LocaleConverter::convertCode("por"));
        self::assertNull(LocaleConverter::convertCode("xxx"));
    }

    #[Test]
    public function mapsRoundTripForPrimaryTags() : void{
        foreach(LocaleConverter::LANGUAGES_MAP as $tag => $code){
            $back = LocaleConverter::convertCode($code);
            self::assertNotNull($back);
            self::assertSame($code, LocaleConverter::convertIETF($back));
        }
    }
}
