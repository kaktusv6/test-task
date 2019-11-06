<?php

use PHPUnit\Framework\TestCase;
use Regulars\RegPhone;

class RegularPhoneTest extends TestCase {
  private $regular;

  protected function setUp(): void {
    $this->regular = new RegPhone();
    parent::setUp();
  }

  public function testRegularTrueTest() {
      $this->assertTrue($this->regular->test('8 (999) 615-49-71'));
      $this->assertTrue($this->regular->test('89996154971'));
      $this->assertTrue($this->regular->test('+79261234567'));
      $this->assertTrue($this->regular->test('89261234567'));
      $this->assertTrue($this->regular->test('79261234567'));
      $this->assertTrue($this->regular->test('+7 926 123 45 67'));
      $this->assertTrue($this->regular->test('8(926)123-45-67'));
      $this->assertTrue($this->regular->test('8123-123-45-67'));
      $this->assertTrue($this->regular->test('8 9261234567'));
      $this->assertTrue($this->regular->test('79261234567'));
      $this->assertTrue($this->regular->test('7 (495)1234567'));
      $this->assertTrue($this->regular->test('7(495) 123 45 67'));
      $this->assertTrue($this->regular->test('89261234567'));
      $this->assertTrue($this->regular->test('8-926-123-45-67'));
      $this->assertTrue($this->regular->test('8 927 1234 234'));
      $this->assertTrue($this->regular->test('8 927 12 12 888'));
      $this->assertTrue($this->regular->test('8 927 12 555 12'));
      $this->assertTrue($this->regular->test('8 927 123 8 123'));
      $this->assertTrue($this->regular->test('79991234567'));
      $this->assertTrue($this->regular->test('+79876543212'));
      $this->assertTrue($this->regular->test('8(954)1233212'));
      $this->assertTrue($this->regular->test('8 (923) 0981231'));
      $this->assertTrue($this->regular->test('8 (923) 098-12-31'));
      $this->assertTrue($this->regular->test('+7 (923) 095-12-31'));
      $this->assertTrue($this->regular->test('7(123) 123-12-12'));
      $this->assertTrue($this->regular->test('7(123) 123-123-12'));
  }

  public function testRegularFalseTest() {
    $this->assertFalse($this->regular->test('+8 (999) 615-49-71'));
    $this->assertFalse($this->regular->test('-0'));
    $this->assertFalse($this->regular->test('asdas 8 (923) 987-123-12-12'));
    $this->assertFalse($this->regular->test('1 (910) 615-49-71'));
    $this->assertFalse($this->regular->test('7(123) 123-as-12'));
    $this->assertFalse($this->regular->test('+8 (923) 123-12-12'));
    $this->assertFalse($this->regular->test('(123) 123-12-12'));
    $this->assertFalse($this->regular->test('adsd'));
    $this->assertFalse($this->regular->test('1231232321'));
  }
}
