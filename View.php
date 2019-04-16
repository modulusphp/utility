<?php

namespace Modulus\Utility;

use Modulus\Utility\Accessor;
use Modulus\Support\Extendable;

class View
{
  use Extendable;

  /**
   * The compiled view
   *
   * @var string
   */
  public $compiled;

  /**
   * Make a view
   *
   * @param string $path
   * @param array  $data
   * @param bool $return
   * @return mixed
   */
  public static function make(string $path, array $data = [], bool $return = false)
  {
    $path = self::getPath($path);

    /**
     * Render error page if this is a whoops call
     */
    if (self::isCalledByWhoops()) {
      return Accessor::view($path, $data, $return)->render();
    }

    return Accessor::view($path, $data, $return);
  }

  /**
   * Check if this is an exception
   *
   * @return bool
   */
  public static function isCalledByWhoops() : bool
  {
    /**
     * Get trace
     */
    $trace = debug_backtrace();

    $trace = end($trace);

    return isset($trace['class']) && $trace['class'] == 'Whoops\Run';
  }

  /**
   * Render a new view
   *
   * @return string
   */
  public function render()
  {
    echo $this->compiled;
  }

  /**
   * Get clean path
   *
   * @param string $path
   * @return void
   */
  public static function getPath(string $path) : string
	{
		$path = str_replace('"', "", $path);
		$path = str_replace("'", "", $path);

		$views = Accessor::$viewsDirectory;
		$file = explode('.', $path);

		foreach($file as $name) {
			if (is_dir($views . DIRECTORY_SEPARATOR . $name)) {
				$views = $views . DIRECTORY_SEPARATOR . $name . DIRECTORY_SEPARATOR;
			}
			else {
				$views = $views . (ends_with($views, DIRECTORY_SEPARATOR) ? '' : '.') . $name;
			}
    }

    $parent = substr(Accessor::$viewsDirectory, strrpos(Accessor::$viewsDirectory, DIRECTORY_SEPARATOR) + 1);

    if (str_contains($views, $parent . '.')) {
      $views = str_replace($parent . '.', $parent . DIRECTORY_SEPARATOR, $views);
    }

		return str_replace(Accessor::$viewsDirectory, '', $views);
  }
}
