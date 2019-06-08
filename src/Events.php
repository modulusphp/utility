<?php

namespace Modulus\Utility;

use Modulus\Support\Extendable;

class Events
{
  use Extendable;

  /**
   * $events
   *
   * @var array
   */
  protected static $events = [];

  /**
   * $register
   *
   * @var array
   */
  public $register = [];

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
   * trigger an event
   *
   * @param string     $name
   * @param null|array $args
   * @return void
   */
  public static function trigger(string $name, ?array $args = null)
  {
    if (!isset(self::$events[$name])) return false;

    foreach (self::$events[$name] as $event => $callback) {
      if (is_callable($callback)) {
        return call_user_func_array($callback, isset($args) ? $args : []);
      }
      else if (is_array($callback)) {
        (new Events)->triggerGroup($callback, $args);
      }
      else if (is_string($callback)) {
        $call = new $callback;
        return call_user_func_array([$call, 'persist'], $args ?? []);
      }
    }
  }

  /**
   * Trigger a grouped event
   *
   * @param mixed ?array
   * @param mixed ?array
   * @return void
   */
  public function triggerGroup(?array $events = [], ?array $args = null)
  {
    foreach($events as $callback) {
      if (is_callable($callback)) {
        call_user_func_array($callback, isset($args) ? $args : []);
      }
      else if (is_string($callback)) {
        $call = new $callback;
        call_user_func_array([$call, 'persist'], $args ?? []);
      }
    }
  }

  /**
   * Register events
   *
   * @return void
   */
  public function register()
  {
    $events = $this->register;

    foreach($events as $name => $event) {
      Events::listen($name, $event);
    }
  }
}
