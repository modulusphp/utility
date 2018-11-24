<?php

namespace Modulus\Utility;

use Faker\Factory;
use Faker\Generator;
use Symfony\Component\Console\Helper\ProgressBar;

class Seeder
{
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
   * @return void
   */
  protected function seed(Generator $faker)
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
    for ($i=0; $i < $this->count; $i++) {
      $progressBar->advance();
      $this->seed(Factory::create());
    }

    $progressBar->finish();
    echo PHP_EOL;

    return true;
  }
}
