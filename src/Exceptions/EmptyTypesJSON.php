<?php


namespace Exceptions;

use Exception;

class EmptyTypesJSON extends Exception {
  protected $message = 'Not found field types_json in request';
}
