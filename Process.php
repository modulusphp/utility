<?php

namespace Modulus\Utility;

use Modulus\Support\Extendable;
use Symfony\Component\Process\Process as SymfonyProcess;

class Process
{
  use Extendable;

  /**
   * Execute process
   *
   * @return SymfonyProcess
   */
  public static function run($command) : SymfonyProcess
  {
    $process = new SymfonyProcess($command);
    $process->run();

    return $process;
  }
}
