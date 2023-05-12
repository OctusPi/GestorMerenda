<?php
namespace Octus\Tests\Utils;
use Octus\App\Utils\Dates;
use PHPUnit\Framework\TestCase;

class DatesTest extends TestCase
{
    public function testDateIsValid(){
        $this->assertTrue(Dates::validDate(date('Y-m-d')));
    }
}