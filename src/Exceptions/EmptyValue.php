<?php

namespace Exceptions;

use Exception;

class EmptyValue extends Exception {
  protected $message = 'Empty value';
}
