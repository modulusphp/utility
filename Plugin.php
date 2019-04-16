<?php

namespace Modulus\Utility;

use Modulus\Support\Filesystem;

class Plugin
{
  /**
   * $dir
   *
   * @var string
   */
  public static $dir;

  /**
   * $view
   *
   * @var View
   */
  public static $view;

  /**
   * $route
   *
   * @var Route
   */
  public static $route;

  /**
   * $config
   *
   * @var Array
   */
  public static $config;

  /**
   * $variables
   *
   * @var GlobalVariables
   */
  public static $variables;

  /**
   * Configure plugin
   *
   * @param mixed $app
   * @return void
   */
  public function instance($app, $dir = __DIR__)
  {
    if ($this::$dir == null) $this::$dir = $dir;

    $this::$variables = $app->variables;
    $this::$route     = $app->route;
    $this::$config    = $app->config;

    $this::medusa($app, $dir);
    $this::routes($app->route);
  }

  /**
   * Boot up service
   *
   * @param mixed $app
   * @return void
   */
  public static function boot($app)
  {
    //
  }

  /**
   * Handle on Exit event
   *
   * @param mixed $app
   * @return bool
   */
  public static function exit($app) : bool
  {
    return false;
  }

  /**
   * Configure console
   *
   * @param mixed $app
   * @return void
   */
  public static function console($app)
  {
    if (Filesystem::isDirectory(Self::$dir . DIRECTORY_SEPARATOR . 'Commands')) {
      $app->craftsman->load(Self::$dir . DIRECTORY_SEPARATOR . 'Commands');
    }
  }

  /**
   * Start scheduler
   *
   * @param Schedule $scheduler
   * @return void
   */
  public static function schedule($scheduler)
  {

  }

  /**
   * Configure medusa
   *
   * @param mixed $app
   * @return void
   */
  public static function medusa($app, $dir = __DIR__)
  {
    $medusa = new $app->view();

    $root = $app->config['app']['dir'];

    $views          = $dir . DIRECTORY_SEPARATOR . '..' .DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR;
    $viewsDirectory = $dir . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR;

    if (Filesystem::isDirectory($views)) {
      $views = $views;
    } else if ($viewsDirectory) {
      $views = $viewsDirectory;
    }

    $medusa->setCacheDirectory($root . $app->config['view']['compiled']);
    $medusa->setViewsDirectory($views);
    $medusa->setViewsExtension($app->config['view']['extension']);

    Self::$view = $medusa;
  }

  /**
   * Return view
   *
   * @param string $view
   * @param mixed array
   * @return void
   */
  public static function view(string $view, array $data = [])
  {
    $global = Self::$variables::get();
    $data = array_merge($global, $data);

    return Self::$view->view($view, $data);
  }

  /**
   * Load routes
   *
   * @param Route $router
   * @return void
   */
  public static function routes($router)
  {
    //
  }
}
