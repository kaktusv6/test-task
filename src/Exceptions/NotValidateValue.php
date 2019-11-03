<?php


namespace Exceptions;


use Exception;
use Throwable;

class NotValidateValue extends Exception {

  public function __construct($type, $code = 0, Throwable $previous = null)
  {
    $message = "Not validate value type of $type";
    parent::__construct($message, $code, $previous);
  }
}
