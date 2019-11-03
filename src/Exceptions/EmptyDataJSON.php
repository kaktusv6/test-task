<?php


namespace Exceptions;


use Exception;

class EmptyDataJSON extends Exception {
  protected $message = 'Not found field data_json in request';
}
