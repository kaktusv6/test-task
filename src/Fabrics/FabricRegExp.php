<?php


namespace Fabrics;

use Exceptions\NotFoundRegular;
use Regulars\IRegular;
use Regulars\RegPhone;

class FabricRegExp {
  static public function getRegExp($code) {
    switch($code) {
      case 'phone': return new RegPhone();
      default: throw new NotFoundRegular();
    }
  }
}
