<?php

require_once '../vendor/autoload.php';

$service = new Sanitizer();

$testRequest = [
  'data_json' => '{"foo": "123.234", "bar": "asd", "baz": "8 (950) 288-56-23"}',
  'types_json' => '{"foo": "число с плавающей точкой", "bar": "строка", "baz": "номер телефона"}'
];

$dataObject = $service->generateObjectFromRequest($testRequest);

print_r($dataObject);
