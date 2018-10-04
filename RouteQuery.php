<?php

namespace Modulus\Utility;

class RouteQuery
{
  /**
   * Persist route query
   *
   * @param mixed $eloquent
   * @param mixed $field
   * @param mixed $value
   * @return mixed
   */
  public function persist($eloquent, $field, $value, $name)
  {
    return $this->handle($eloquent, $field, $value, $name);
  }
}