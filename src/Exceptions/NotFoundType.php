<?php

namespace Exceptions;

use Exception;
use Throwable;

class NotFoundType extends Exception {

  public function __construct($type, $code = 0, Throwable $previous = null) {
    $message = "Not found type $type";
    parent::__construct($message, $code, $previous);
  }
}
