<?php

namespace Modulus\Utility;

use Modulus\Http\CSRF;
use JeffOchoa\ValidatorFactory;
use Modulus\Utility\Variable;

class GlobalVariables
{
  /**
   * Get global variables
   *
   * @return array
   */
  public static function get() : array
  {
    return [
      'csrf_token' => CSRF::generate(),
      'errors' => Variable::has('validation.errors') ? Variable::get('validation.errors') : (new ValidatorFactory())->make([], [])->errors(),
      'old' => Variable::has('form.old') ? Variable::get('form.old') : [],
    ];
  }
}