<?php

use Exceptions\NotFoundType;
use Fabrics\FabricValues;
use PHPUnit\Framework\TestCase;

class FabricValuesTest extends TestCase {

  public function testAccessConvertToPhone() {
    $this->assertEquals('79999999999', FabricValues::convertToPhone('+7 (999) 999-99-99'));
    $this->assertEquals('79999999999', FabricValues::convertToPhone('8 (999) 999-99-99'));
    $this->assertEquals('79146452956', FabricValues::convertToPhone('8 (914) 645-29-56'));
  }

  public function testGenerateDataForInteger() {
    $this->assertEquals(123, FabricValues::getValueByType('123', 'целое число'));
    $this->assertEquals(123, FabricValues::getValueByType('123', 'целое число'));
    $this->assertEquals(0, FabricValues::getValueByType('0', 'целое число'));
    $this->assertEquals(-41, FabricValues::getValueByType('-41', 'целое число'));
  }

  public function testCannotGenerateDataForInteger() {
    $this->expectException(\Exceptions\NotFoundType::class);
    FabricValues::getValueByType('8 (999) 123-123-12', 'целый номер');
    $this->expectException(\Exceptions\NotFoundType::class);
    FabricValues::getValueByType('[123,1123]', 'массив');
  }

  public function testGenerateDataForString() {
    $this->assertEquals('string', FabricValues::getValueByType('string', 'строка'));
    $this->assertEquals('123-string', FabricValues::getValueByType('123-string', 'строка'));
    $this->assertEquals('', FabricValues::getValueByType('', 'строка'));
  }
}
