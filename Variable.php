<?php

namespace Modulus\Utility;

class Variable
{
  /**
   * All variables
   *
   * @var array $data
   */
  public static $data;

  /**
   * Check if variables exists
   *
   * @param string $name
   * @return bool
   */
  public static function has(string $name) : bool
  {
    return isset(Variable::$data[$name]) ? true : false;
  }

  /**
   * Get variable
   *
   * @param string $name
   * @return mixed
   */
  public static function get(string $name)
  {
    return Variable::has($name) ? Variable::$data[$name] : null;
  }
}
