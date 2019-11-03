<?php


namespace Services;


use Exceptions\EmptyDataJSON;
use Exceptions\EmptyTypesJSON;
use Exceptions\NotValidateValue;
use Fabrics\FabricServices;
use Fabrics\FabricValues;

class SanitizerService implements ISanitizerService {

  private $validationService;

  public function __construct() {
    $this->validationService = FabricServices::getService('validate');
  }

  function getDataFromRequest($request): array {
    if (!isset($request['data_json']) || empty($request['data_json'])) {
      throw new EmptyDataJSON();
    }

    if (!isset($request['types_json']) || empty($request['types_json'])) {
      throw new EmptyTypesJSON();
    }

    $dataRequest = [
      'data' => json_decode($request['data_json'], true),
      'types' => json_decode($request['types_json'], true)
    ];
    return $dataRequest;
  }

  function generateObject($data, $types): object {
    return (object)$this->generateValueOfAssocArray($data, $types);
  }

  private function isAssocArray($array) {
    return is_array($array) && array_keys($array) !== range(0, count($array) - 1);
  }

  private function checkValidateValue($value, $type) {
    $isValidValue = $this->validationService->validateValueOfType($value, $type);
    if (!$isValidValue) {
      throw new NotValidateValue($type);
    }
  }

  private function generateValueOfArray($array, $type): array {
    $result = [];
    foreach ($array as $value) {
      $this->checkValidateValue($value, $type);
      $result[] = FabricValues::getValueByType($value, $type);
    }

    return $result;
  }

  private function generateValueOfAssocArray($array, $types) {
    $result = $array;
    foreach ($array as $fieldName => $value) {
      $type = $types[$fieldName];
      if ($this->isAssocArray($value)) {
        $result[$fieldName] = $this->generateValueOfAssocArray($value, $type);
      }
      elseif (is_array($value)) {
        $result[$fieldName] = $this->generateValueOfArray($value, $type);
      }
      else {
        $this->checkValidateValue($value, $type);
        $result[$fieldName] = FabricValues::getValueByType($value, $type);
      }
    }

    return $result;
  }
}
