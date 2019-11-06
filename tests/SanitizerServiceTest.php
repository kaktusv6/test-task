<?php

use Exceptions\NotFoundType;
use Exceptions\NotFoundTypeForField;
use Exceptions\NotValidateValue;
use PHPUnit\Framework\TestCase;

class SanitizerServiceTest extends TestCase
{
  private $service;

  protected function setUp(): void {
    $this->service = new Sanitizer();
    parent::setUp();
  }

  public function testGenerateObjectFirst() {
    $accessObject = (object)[
      'foo' => 123,
      'foo1' => -1223,
      'foo2' => 0,
      'bar' => 'string',
      'bar1' => 'str str 123 !@#',
      'foo_arr' => [123, 12, 1, 0, 54, 34],
      'bar_arr' => ['str', 'Lorem lorem str', '123-123012'],
      'phone' => '79231231212',
      'phone1' => '79231231212',
      'phone2' => '71234545534',
      'phone_arr' => [],
      'phone_arr_no_empty' => [
        '79231231212',
        '79231231212',
        '71234545534',
        '79991230987',
        '79991230987',
        '79991230987',
        '79991230987',
      ],
      'int_arr' => [],
      'str_arr' => [],
      'assoc_arr' => [
        'foo' => 67823,
        'bar' => 'string',
        'foo_arr' => [
            1232374,
            122374,
            12374,
            2374,
            0,
            541232374,
            342374,
            1231232374
        ],
        'bar_arr' => ['str', 'Lorem lorem str', '123123012', '+79832347645'],
        'phone' => '79231231212',
        'assoc_arr' => [
          'foo' => 123,
          'str' => 'string string',
          'phone' => '79233215634',
          'foo_arr' => []
        ]
      ]
    ];

    echo __DIR__;
    $dataJson = file_get_contents(__DIR__ . '/tests_data/test_1/data.json');
    $typesJson = file_get_contents(__DIR__ . '/tests_data/test_1/types.json');
    $testRequest = [
      'data_json' => $dataJson,
      'types_json' => $typesJson
    ];
    $obj = $this->service->generateObjectFromRequest($testRequest);
    $this->assertEquals($accessObject, $obj);
  }

  public function testGenerateObjectFromRequestSecond() {
    $accessObject = (object)[
      'int' => 2342,
      'float_1' => 0.1234,
      'float_2' => 110.0234,
      'float_3' => 1234.0,
      'string_ar' => [
        'fl' => 54.2342,
        'str_arrrr' => ['123', 'asd asd ', '     ', '\n\n\n\n\n']
      ],
      'phone' => '79823411233',
      'phone_1' => 79812341234
    ];;

    $dataJson = file_get_contents(__DIR__ . '/tests_data/test_2/data.json');
    $typesJson = file_get_contents(__DIR__ . '/tests_data/test_2/types.json');
    $testRequest = [
      'data_json' => $dataJson,
      'types_json' => $typesJson
    ];
    $obj = $this->service->generateObjectFromRequest($testRequest);
    $this->assertEquals($accessObject, $obj);
  }

  public function testGenerateEmptyObject() {
    $data = "{}";
    $types = "{}";
    $testRequest = [
      'data_json' => $data,
      'types_json' => $types
    ];
    $obj = $this->service->generateObjectFromRequest($testRequest);
    $this->assertTrue(empty((array)$obj));
  }

  public function testExceptionNotFoundTypeForField() {
    $this->expectException(NotFoundTypeForField::class);
    $data = '{"foo": "123", "str": "str"}';
    $types = '{"str": "строка"}';
    $testRequest = [
      'data_json' => $data,
      'types_json' => $types
    ];
    $this->service->generateObjectFromRequest($testRequest);
  }

  public function testFailValidatePhone() {
    $this->expectException(NotValidateValue::class);
    $data = '{"foo": "123", "str": "str"}';
    $types = '{"foo": "номер телефона", "str": "строка"}';
    $testRequest = [
      'data_json' => $data,
      'types_json' => $types
    ];
    $this->service->generateObjectFromRequest($testRequest);
  }

  public function testFailValidateInt() {
    $this->expectException(NotValidateValue::class);
    $data = '{"foo": "123", "str": "str"}';
    $types = '{"foo": "целое число", "str": "целое число"}';
    $testRequest = [
      'data_json' => $data,
      'types_json' => $types
    ];
    $this->service->generateObjectFromRequest($testRequest);
  }

  public function testFailValidateFloat() {
    $this->expectException(NotValidateValue::class);
    $data = '{"foo": "876asd", "str": "str"}';
    $types = '{"foo": "число с плавающей точкой", "str": "строка"}';
    $testRequest = [
      'data_json' => $data,
      'types_json' => $types
    ];
    $this->service->generateObjectFromRequest($testRequest);
  }
}
