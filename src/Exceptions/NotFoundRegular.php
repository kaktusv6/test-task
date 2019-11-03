<?php


namespace Exceptions;

use Exception;
use Throwable;

class NotFoundRegular extends Exception {
  public function __construct($regular, $code = 0, Throwable $previous = null) {
    $message = "Not found regular $regular";
    parent::__construct($message, $code, $previous);
  }
}
