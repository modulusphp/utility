<?php

namespace Modulus\Utility;

use Faker\Factory;
use Faker\Generator;
use Modulus\Support\Extendable;
use Symfony\Component\Console\Helper\ProgressBar;

class Seeder
{
  use Extendable;

  /**
   * $count
   *
   * @var integer
   */
  public $count = 10;

  /**
   * seed
   *
   * @param Generator $faker
   * @param int|null $index
   * @return void
   */
  protected function seed(Generator $faker, ?int $index = null)
  {
    //
  }

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run(ProgressBar $progressBar)
  {
    for ($i = 0; $i < $this->count; $i++) {
      $progressBar->advance();
      $this->seed(Factory::create(), $i);
    }

    $progressBar->finish();
    echo PHP_EOL;

    return true;
  }
}
