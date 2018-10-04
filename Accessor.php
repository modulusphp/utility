<?php

namespace Modulus\Utility;

use Modulus\Directives\Csrf;
use Modulus\Directives\Using;
use Modulus\Utility\GlobalVariables;
use Modulus\Directives\ConfigToJsonString;
use AtlantisPHP\Medusa\Template as Medusa;

class Accessor
{
  /**
   * Medusa View Component
   *
   * @var $viewComponent
   */
  public static $viewComponent;

  /**
   * Cache directory
   *
   * @var $viewsCache
   */
  public static $viewsCache;

  /**
   * Views directory
   *
   * @var $viewsDirectory
   */
  public static $viewsDirectory;

  /**
   * Views extension
   *
   * @var $viewsExtension
   */
  public static $viewsExtension;

  /**
   * Views default templating engine
   *
   * @var $viewsEngine
   */
  public static $viewsEngine = 'modulus';

  /**
   * Application root
   *
   * @var string
   */
  public static $appRoot;

  /**
   * Create a new Medusa Object
   *
   * @return void
   */
  public static function requireView() : void
  {
    $medusa = new Medusa(self::$viewsEngine);

    $medusa->setCacheDirectory(self::$viewsCache);
    $medusa->setViewsDirectory(self::$viewsDirectory);
    $medusa->setViewsExtension(self::$viewsExtension);

    $medusa->register(Using::class);
    $medusa->register(Csrf::class);
    $medusa->register(ConfigToJsonString::class);

    self::$viewComponent = $medusa;
  }

  /**
   * Make a view
   *
   * @param  string $path
   * @param  array  $data
   */
  public static function view(string $path, array $data = [], bool $return = false)
  {
    $data = array_merge(GlobalVariables::get(), $data);

    if ($return) return self::$viewComponent->make($path, $data);

    return self::$viewComponent->view($path, $data);
  }
}