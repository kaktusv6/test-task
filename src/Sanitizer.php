<?php

use Enum\Types;
use Exceptions\EmptyDataJSON;
use Exceptions\EmptyTypesJSON;
use Exceptions\NotFoundType;
use Exceptions\NotFoundTypeForField;
use Exceptions\NotValidateValue;
use Regulars\RegPhone;

class Sanitizer {

  private $regularPhone;

  public function __construct() {
    $this->regularPhone = new RegPhone();
  }

  function generateObjectFromRequest($request): object {
    $data = $this->getDataFromRequest($request);
    return (object)$this->generateValueOfAssocArray($data['data'], $data['types']);
  }

  private function getDataFromRequest($request): array {
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

  private function isAssocArray($array) {
    return is_array($array) && array_keys($array) !== range(0, count($array) - 1);
  }

  private function generateValueOfArray($array, $type): array {
    $result = [];
    foreach ($array as $value) {
      $this->checkValidateValue($value, $type);
      $result[] = $this->getValueByType($value, $type);
    }

    return $result;
  }

  private function generateValueOfAssocArray($array, $types) {
    $result = $array;
    foreach ($array as $fieldName => $value) {
      if (!isset($types[$fieldName])) {
        throw new NotFoundTypeForField($fieldName);
      }
      $type = $types[$fieldName];

      if ($this->isAssocArray($value)) {
        $result[$fieldName] = $this->generateValueOfAssocArray($value, $type);
      }
      elseif (is_array($value)) {
        $result[$fieldName] = $this->generateValueOfArray($value, $type);
      }
      else {
        $this->checkValidateValue($value, $type);
        $result[$fieldName] = $this->getValueByType($value, $type);
      }
    }

    return $result;
  }

  private function checkValidateValue($value, $type) {
    $isValidValue = $this->validateValueOfType($value, $type);
    if (!$isValidValue) {
      throw new NotValidateValue($value, $type);
    }
  }

  private function validateValueOfType($value, $type) {
    switch ($type) {
      case Types::INT:
        $isValidValue = is_int(filter_var($value, FILTER_VALIDATE_INT));
        break;
      case Types::STRING:
        $isValidValue = is_string($value);
        break;
      case Types::PHONE:
        $isValidValue = $this->regularPhone->test($value);
        break;
      case Types::FLOAT:
        $isValidValue = is_float(filter_var($value, FILTER_VALIDATE_FLOAT));
        break;

      default: throw new NotFoundType($type);
    }

    return $isValidValue;
  }

  private function convertToPhone($value) {
    $removeStartPhone = preg_replace($this->regularPhone->getCheckStartString(), '', $value);
    $clearDivisionPhone = preg_replace($this->regularPhone->getDivisionChar(), '', $removeStartPhone);

    return "7$clearDivisionPhone";
  }

  private function getValueByType($value, $type) {
    switch ($type) {
      case Types::INT: return intval($value);
      case Types::STRING: return strval($value);
      case Types::PHONE: return $this->convertToPhone($value);
      case Types::FLOAT: return floatval($value);
    }

    throw new NotFoundType($type);
  }
}
