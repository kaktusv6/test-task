<?php

require_once '../vendor/autoload.php';

use \Services\SanitizerService;

$service = new SanitizerService();

$testPost = [
  'data_json' => '{"foo": "123", "bar": "asd", "baz": "8 (950) 288-56-23"}',
  'types_json' => '{"foo": "целое число", "bar": "строка", "baz": "номер телефона"}'
];
$dataRequest = $service->getDataFromRequest($testPost);
$dataObject = $service->generateObject($dataRequest['data'], $dataRequest['types']);
print_r($dataObject);
