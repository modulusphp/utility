<?php

namespace Modulus\Utility;

use Modulus\Directives\Csrf;
use Modulus\Directives\Using;
use Modulus\Directives\Partial;
use Modulus\Utility\GlobalVariables;
use App\Resolvers\DirectivesResolver;
use AtlantisPHP\Medusa\Template as Medusa;
use Modulus\Directives\ConfigToJsonString;
use Modulus\Hibernate\Mail\Directives\EmailView;
use Modulus\Hibernate\Mail\Directives\EmailAction;
use Modulus\Hibernate\Mail\Directives\EmailFooter;

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

    $medusa->register(Partial::class);
    $medusa->register(EmailView::class);
    $medusa->register(EmailAction::class);
    $medusa->register(EmailFooter::class);
    $medusa->register(Using::class);
    $medusa->register(Csrf::class);
    $medusa->register(ConfigToJsonString::class);

    if (class_exists(DirectivesResolver::class)) {
      (new DirectivesResolver)->start([
        'view' => $medusa
      ]);
    }

    self::$viewComponent = $medusa;
  }

  /**
   * Make a view
   *
   * @param string $path
   * @param array $data
   * @return View
   */
  public static function view(string $path, array $data = [], bool $return = false)
  {
    $data = array_merge(GlobalVariables::get(), $data);

    if ($return) return self::$viewComponent->make($path, $data);

    $view = new View;

    $view->compiled = self::$viewComponent->make($path, $data);

    return $view;
  }
}
