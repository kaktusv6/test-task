<?php


namespace Regulars;


class RegPhone {
  private $regular = '/^(8|\+?7)(\d{10})/';
  private $divisionChar = '/[^\d]/';
  private $checkStartString = '/^(8|\+?7)/';

  public function getRegular(): string {
    return $this->regular;
  }

  public function getDivisionChar(): string {
    return $this->divisionChar;
  }

  public function getCheckStartString(): string {
    return $this->checkStartString;
  }

  public function test($value): bool {
    $isPhone = boolval(preg_match($this->checkStartString, $value));
    $clearPhone = preg_replace($this->divisionChar, '', $value);
    $isPhone = $isPhone && boolval(preg_match($this->regular, $clearPhone));
    return $isPhone;
  }
}
