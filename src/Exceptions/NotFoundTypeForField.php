<?php


namespace Exceptions;


use Exception;
use Throwable;

class NotFoundTypeForField extends Exception {
  public function __construct($type, $code = 0, Throwable $previous = null) {
    $message = "Not found type for field by name '$type'";
    parent::__construct($message, $code, $previous);
  }
}
