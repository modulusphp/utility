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
      if (isset(HttpFoundation::$routeMiddleware[$value])) {
        $all[] = HttpFoundation::$routeMiddleware[$value];
      }
    }

    $middlwares = array_merge(HttpFoundation::$middlewareGroup[$group] ?? [], $all);
    $middlwares = array_merge(HttpFoundation::$middleware, $middlwares);

    foreach($middlwares as $middleroute) {
      if ((new $middleroute)->handle($request, true) == false) {
        exit;
      }
    }
  }
}