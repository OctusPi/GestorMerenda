<?php
namespace Octus\Tests\Utils;
use Octus\App\Utils\Money;
use PHPUnit\Framework\TestCase;

class MoneyTest extends TestCase
{
    public function testCoversionToFloat(){
        $this->assertIsFloat(Money::getFloat('valor'));
    }

    public function testConversionToCurrency(){
        $this->assertEquals('R$1.100,22', Money::getCurrency(1100.22));
    }
}