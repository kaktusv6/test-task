<?php


namespace Services;


interface ISanitizerService {
  function getDataFromRequest($request): array;
  function generateObject($data, $types);
}
