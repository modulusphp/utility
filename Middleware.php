<?php

namespace Modulus\Utility;

use App\Http\HttpFoundation;

class Middleware
{
  /**
   * Run middleware
   *
   * @param \Modulus\Http\Request $request
   * @param object $route
   * @param string $group
   * @param array $all
   * @return void
   */
  public static function run($request, object $route, string $group, array $all = [])
  {
    foreach ($route->middleware as $value) {
      if (isset(HttpFoundation::$routeMiddleware[explode(':', $value)[0]]) || class_exists($value)) {
        $all[] = $value;
      }
    }

    $first = isset(HttpFoundation::$middlewareGroup[
      isset($route->middleware[0]) ? $route->middleware[0] : null
    ]) ? true : null;

    if ($first) {
      $middlwares = array_merge(HttpFoundation::$middlewareGroup[$route->middleware[0]] ?? [], $all);
    } else {
      $middlwares = $all;
    }

    $middlwares = array_merge(HttpFoundation::$middleware, $middlwares);

    foreach($middlwares as $middleroute) {
      $attributes = [];

      if (isset(HttpFoundation::$routeMiddleware[explode(':', $middleroute)[0]])) {
        $route = explode(':', $middleroute);

        if (count($route) > 1) {
          $attributes = explode(',', explode(':', $middleroute)[1]);
        }

        $middleroute = HttpFoundation::$routeMiddleware[explode(':', $middleroute)[0]];
      }

      if ((new $middleroute)->handle($request, true, $attributes) == false) {
        exit;
      }
    }
  }
}
