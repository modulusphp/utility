<?php

namespace Modulus\Utility;

use Symfony\Component\Process\Process as SymfonyProcess;

class Process
{
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