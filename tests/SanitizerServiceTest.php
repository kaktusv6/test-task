<?php


use Fabrics\FabricServices;
use PHPUnit\Framework\TestCase;

class SanitizerServiceTest extends TestCase
{
  private $service;

  protected function setUp(): void {
    $this->service = FabricServices::getService('sanitizer');
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
        'foo' => 123,
        'bar' => 'string',
        'foo_arr' => [123, 12, 1, 0, 54123, 34, 123123],
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
    $testPost = [
      'data_json' => $dataJson,
      'types_json' => $typesJson
    ];
    $dataRequest = $this->service->getDataFromRequest($testPost);
    $obj = $this->service->generateObject($dataRequest['data'], $dataRequest['types']);
    $this->assertEquals($accessObject, $obj);
  }

  public function testGenerateObjectSecond() {
    $accessObject = (object)[
      'int' => 2342,
      'string_ar' => [
        'fl' => 54.2342,
        'str_arrrr' => ['123', 'asd asd ', '     ', '\n\n\n\n\n']
      ],
      'phone' => '79823411233',
      'phone_1' => 79812341234
    ];;

    $dataJson = file_get_contents(__DIR__ . '/tests_data/test_2/data.json');
    $typesJson = file_get_contents(__DIR__ . '/tests_data/test_2/types.json');
    $testPost = [
      'data_json' => $dataJson,
      'types_json' => $typesJson
    ];
    $dataRequest = $this->service->getDataFromRequest($testPost);
    $obj = $this->service->generateObject($dataRequest['data'], $dataRequest['types']);
    $this->assertEquals($accessObject, $obj);
  }

  public function testGenerateEmptyObject() {
    $data = [];
    $types = [];
    $obj = $this->service->generateObject($data, $types);
    $this->assertTrue(empty((array)$obj));
  }
}
