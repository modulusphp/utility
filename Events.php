<?php

namespace Modulus\Utility;

class Events
{
  /**
   * $events
   *
   * @var array
   */
  protected static $events = [];

  /**
   * listen to event
   *
   * @param string $name
   * @param mixed $callback
   * @return void
   */
  public static function listen(string $name, $callback)
  {
    self::$events[$name][] = $callback;
  }

  /**
   * trigger event
   *
   * @param string $name
   * @param mixed ?array
   * @return void
   */
  public static function trigger(string $name, ?array $args = null)
  {
    if (!isset(self::$events[$name])) return false;

    foreach (self::$events[$name] as $event => $callback) {
      if (is_callable($callback)) {
        return call_user_func_array($callback, isset($args) ? $args : []);
      }
      else if (is_string($callback)) {
        $call = new $callback;
        return call_user_func_array([$call, 'persist'], $args ?? []);
      }
    }
  }
}