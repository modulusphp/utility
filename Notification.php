<?php

namespace Modulus\Utility;

class Notification
{
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