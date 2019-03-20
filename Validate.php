<?php

namespace Modulus\Utility;

use Modulus\Http\Rest;
use JeffOchoa\ValidatorFactory;

class Validate
{
  /**
   * Make a new validator
   *
   * @param array $data
   * @param array $rules
   * @param mixed $unknown
   * @param mixed $custom
   * @return mixed
   */
  public static function make(array $data, array $rules, $unknown = null, $custom = [])
  {
    $factory = new ValidatorFactory();

    if (is_array($unknown) && count($unknown) > 0) {
      $custom = $unknown;
    }

    $response = $factory->make($data, $rules, $custom);

    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
      strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) === 'XMLHTTPREQUEST' &&
      $response->fails()) {
        return Rest::response()
                    ->json($response->errors()->toArray(), 422);

        die();
    }

    return $response;
  }
}
