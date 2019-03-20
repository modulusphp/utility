<?php

namespace Modulus\Utility;

use Modulus\Support\Extendable;

class Event
{
  use Extendable;

  /**
   * persist event
   *
   * @return void
   */
  public function persist()
  {
    return call_user_func_array(array($this, 'handle'), func_get_args());
  }
}
