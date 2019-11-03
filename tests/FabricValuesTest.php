<?php

use Enum\Types;
use Exceptions\NotFoundType;
use Fabrics\FabricValues;
use PHPUnit\Framework\TestCase;

class FabricValuesTest extends TestCase {

  public function testAccessConvertToPhone() {
    $this->assertEquals('79999999999', FabricValues::convertToPhone('+7 (999) 999-99-99'));
    $this->assertEquals('79999999999', FabricValues::convertToPhone('8 (999) 999-99-99'));
    $this->assertEquals('79146452956', FabricValues::convertToPhone('8 (914) 6452956'));
    $this->assertEquals('79146352756', FabricValues::convertToPhone('89146352756'));
  }

  public function testGenerateDataForInteger() {
    $this->assertEquals(123, FabricValues::getValueByType('123', Types::INT));
    $this->assertEquals(123, FabricValues::getValueByType('123', Types::INT));
    $this->assertEquals(0, FabricValues::getValueByType('0', Types::INT));
    $this->assertEquals(-41, FabricValues::getValueByType('-41', Types::INT));
  }

  public function testCannotGenerateDataForInteger() {
    $this->expectException(NotFoundType::class);
    FabricValues::getValueByType('8 (999) 123-123-12', 'целый номер');
    $this->expectException(NotFoundType::class);
    FabricValues::getValueByType('[123,1123]', 'массив');
  }

  public function testGenerateDataForString() {
    $this->assertEquals('string', FabricValues::getValueByType('string', Types::STRING));
    $this->assertEquals('123-string', FabricValues::getValueByType('123-string', Types::STRING));
    $this->assertEquals('', FabricValues::getValueByType('', Types::STRING));
  }
}
