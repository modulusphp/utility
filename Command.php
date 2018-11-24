<?php

namespace Modulus\Utility;

use Modulus\Utility\Accessor;
use Symfony\Component\Process\Process as SymfonyProcess;

class Command
{
  /**
   * Run command
   *
   * @param string $args
   * @return SymfonyProcess $process
   */
  public static function run(string $args) : SymfonyProcess
  {
    $process = new SymfonyProcess('php ' . Accessor::$appRoot . 'craftsman ' . $args);
    $process->run();

    return $process;
  }

  /**
   * Start command
   *
   * @param string $args
   * @return SymfonyProcess $process
   */
  public static function start(string $args) : SymfonyProcess
  {
    $process = new SymfonyProcess('php ' . Accessor::$appRoot . 'craftsman ' . $args);
    $process->start();

    return $process;
  }

  /**
   * Run and wait
   *
   * @param string $args
   * @return SymfonyProcess $process
   */
  public static function wait(string $args) : ?SymfonyProcess
  {
    $process = new SymfonyProcess('php ' . Accessor::$appRoot . 'craftsman ' . $args);

    $process->start();
    $process->wait();
    $process->stop();

    return $process;
  }
}
