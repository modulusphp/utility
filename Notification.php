<?php

namespace Modulus\Utility;

use Modulus\Support\Extendable;

class Notification
{
  use Extendable;

  /**
   * $notification
   *
   * @var Notification
   */
  protected $notification;

  /**
   * __construct
   *
   * @param Notification $notification
   * @return void
   */
  public function __construct(Notification $notification)
  {
    $this->notification = $notification;
  }

  /**
   * Send notification now
   *
   * @return mixed
   */
  public function now()
  {
    return Notification::make($this->notification);
  }

  /**
   * Make a new notification and send it
   *
   * @param Notification $notification
   * @return array
   */
  public static function make(Notification $notification) : array
  {
    return $notification->notify();
  }
}
