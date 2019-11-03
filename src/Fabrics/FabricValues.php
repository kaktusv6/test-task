<?php


namespace Fabrics;

use Exceptions\NotFoundType;

class FabricValues {
  static public function getValueByType($value, $type) {
    switch ($type) {
      case 'целое число': return intval($value);
      case 'строка': return strval($value);
      case 'номер телефона': return FabricValues::convertToPhone($value);
    }

    throw new NotFoundType();
  }

  static public function convertToPhone($value) {
    $regPhone = FabricRegExp::getRegExp('phone');

    $removeStartPhone = preg_replace($regPhone->getCheckStartString(), '', $value);
    $clearDivisionPhone = preg_replace($regPhone->getDivisionChar(), '', $removeStartPhone);

    return "7$clearDivisionPhone";
  }
}
