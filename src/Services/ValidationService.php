<?php


namespace Services;


use Enum\Types;
use Exceptions\NotFoundType;
use Fabrics\FabricRegExp;

class ValidationService implements IValidationService {
  private $regularPhone;

  public function __construct() {
    $this->regularPhone = FabricRegExp::getRegExp('phone');
  }

  public function validateValueOfType($value, $type) {
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
}
