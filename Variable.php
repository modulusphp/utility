<?php

namespace Modulus\Utility;

use Modulus\Support\Extendable;

class Variable
{
  use Extendable;

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
   * @param null|string $syntax
   * @return mixed
   */
  public static function has(string $name, ?string $syntax = null)
  {
    if (isset($_SESSION['application']['with'][$name])) {
      $_SESSION['application']['flash']['used'] = true;

      $name = $_SESSION['application']['with'][$name];

      return $syntax ? str_replace(':message', $name, $syntax) : true;
    }

    return isset(Variable::$data[$name]) ? ($syntax ? str_replace(':message', Variable::$data[$name], $syntax) : true) : false;
  }

  /**
   * Get variable
   *
   * @param string $name
   * @return mixed
   */
  public static function get(string $name)
  {
    if (isset($_SESSION['application']['with'][$name])) {
      $_SESSION['application']['flash']['used'] = true;
      return $_SESSION['application']['with'][$name];
    }

    return Variable::has($name) ? Variable::$data[$name] : null;
  }
}
