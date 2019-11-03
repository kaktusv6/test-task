<?php


namespace Fabrics;


use Services\SanitizerService;
use Services\ValidationService;

class FabricServices {
  static public function getService($code) {
    switch ($code) {
      case 'validate': return new ValidationService();
      case 'sanitizer': return new SanitizerService();
    }
  }
}
