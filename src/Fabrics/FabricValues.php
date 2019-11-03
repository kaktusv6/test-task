<?php


namespace Fabrics;

use Enum\Types;
use Exceptions\NotFoundType;

class FabricValues {
  static public function getValueByType($value, $type) {
    switch ($type) {
      case Types::INT: return intval($value);
      case Types::STRING: return strval($value);
      case Types::PHONE: return FabricValues::convertToPhone($value);
      case Types::FLOAT: return floatval($value);
    }

    throw new NotFoundType($type);
  }

  static public function convertToPhone($value) {
    $regPhone = FabricRegExp::getRegExp('phone');

    $removeStartPhone = preg_replace($regPhone->getCheckStartString(), '', $value);
    $clearDivisionPhone = preg_replace($regPhone->getDivisionChar(), '', $removeStartPhone);

    return "7$clearDivisionPhone";
  }
}
