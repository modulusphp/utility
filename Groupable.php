<?php

namespace Modulus\Utility;

use ReflectionClass;
use Modulus\Support\Extendable;
use Illuminate\Database\Eloquent\Collection;

class Groupable
{
  use Extendable;

  /**
   * $model
   *
   * @var Model
   */
  protected $model;

  /**
   * $all
   *
   * @var Collection
   */
  protected $all;

  /**
   * model
   *
   * @return string
   */
  public function model() : string
  {
    return $this->model ?? get_class();
  }

  /**
   * assign
   *
   * @param Collection $collection
   * @return Collection
   */
  public function assign(Collection $collection) : Groupable
  {
    $this->all = $collection;
    return $this;
  }

  /**
   * all
   *
   * @return Collection
   */
  public function all() : Collection
  {
    return $this->all ?? new Collection;
  }
}
