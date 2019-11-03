<?php


namespace Services;


use Exceptions\NotFoundType;
use Fabrics\FabricRegExp;

class ValidationService implements IValidationService {
  private $regularPhone;

  public function __construct() {
    $this->regularPhone = FabricRegExp::getRegExp('phone');
  }

  public function validateValueOfType($value, $type) {
    switch ($type) {
      case "целое число":
        $isValidValue = is_int(filter_var($value, FILTER_VALIDATE_INT));
      break;
      case "строка":
        $isValidValue = is_string($value);
      break;
      case "номер телефона":
        $isValidValue = $this->regularPhone->test($value);
      break;
      default: throw new NotFoundType();
    }

    return $isValidValue;
  }
}
