<?php


namespace Exceptions;

use Exception;
use Throwable;

class NotValidateValue extends Exception {

  public function __construct($value, $type, $code = 0, Throwable $previous = null) {
    $message = "Not validate value '$value' type of '$type'";
    parent::__construct($message, $code, $previous);
  }
}
