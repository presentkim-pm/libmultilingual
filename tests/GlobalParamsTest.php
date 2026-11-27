<?php

declare(strict_types=1);

namespace kim\present\libmultilingual\tests;

use kim\present\libmultilingual\GlobalParams;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;

#[CoversClass(GlobalParams::class)]
final class GlobalParamsTest extends TestCase{

    #[Test]
    public function hasDefaults() : void{
        $all = GlobalParams::getAll();
        self::assertSame("\n", $all["n"]);
        self::assertSame("\n", $all["br"]);
        self::assertSame("\t", $all["tab"]);
        self::assertSame("\t", $all["t"]);
    }

    #[Test]
    public function setAndRemove() : void{
        GlobalParams::set("testParam", "value");
        self::assertSame("value", GlobalParams::getAll()["testParam"]);
        GlobalParams::remove("testParam");
        self::assertArrayNotHasKey("testParam", GlobalParams::getAll());
    }
}
