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
   * Default count
   *
   * @var int
   */
  public $count  = 10;

  /**
   * Default locale
   *
   * @var string
   */
  public $locale = null;

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
    $faker = Factory::create($this->getLocale());

    for ($i = 0; $i < $this->count; $i++) {
      $progressBar->advance();
      $this->seed($faker, $i);
    }

    $progressBar->finish();
    echo PHP_EOL;

    return true;
  }

  /**
   * Get default locale
   *
   * @return string
   */
  private function getLocale() : string
  {
    $locale = ($this->locale ?? config('faker.locale.default'));

    if (
      $locale !== null &&
      is_array(config('faker.locale.supported')) &&
      in_array(config('faker.locale.default'), config('faker.locale.supported'))
    ) {
      return $locale;
    }

    return 'en_US';
  }
}
