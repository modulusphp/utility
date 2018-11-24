<?php

namespace Modulus\Utility;

class Scheduler
{
  /**
   * Start scheduler
   *
   * @param Schedule $scheduler
   * @return void
   */
  public function run($scheduler)
  {
    $this->schedule($scheduler);
  }
}
