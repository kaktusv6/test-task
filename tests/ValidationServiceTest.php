<?php


use Enum\Types;
use PHPUnit\Framework\TestCase;
use \Fabrics\FabricServices;

class ValidationServiceTest extends TestCase {
  private $service;

  protected function setUp(): void {
    $this->service = FabricServices::getService('validate');
    parent::setUp();
  }

  public function testValidationForInteger() {
    $values = [
      '123' => true,
      '-0' => true,
      '+0' => true,
      '0' => true,
      '-123' => true,
      '+5324' => true,
      '123+123' => false,
      'asd+123' => false,
      '' => false
    ];
    $type = Types::INT;
    foreach ($values as $value => $result) {
      $this->assertEquals($result, $this->service->validateValueOfType($value, $type));;
    }
  }

  public function testValidationForString() {
    $type = Types::STRING;
    $this->assertTrue($this->service->validateValueOfType('123asd', $type));
    $this->assertTrue($this->service->validateValueOfType('Lorem lorem lorenm1001', $type));
    $this->assertTrue($this->service->validateValueOfType('back first second', $type));
    $this->assertTrue($this->service->validateValueOfType('123+0-543', $type));
    $this->assertTrue($this->service->validateValueOfType('12321331232130213', $type));
    $this->assertTrue($this->service->validateValueOfType('-123*&#RBELBFYPSDC', $type));
    $this->assertTrue($this->service->validateValueOfType('+53sadsjk;bf2sfzdfd4', $type));
  }
}
