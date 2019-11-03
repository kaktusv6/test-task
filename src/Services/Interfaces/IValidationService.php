<?php


namespace Services;


interface IValidationService {
  public function validateValueOfType($value, $type);
}
