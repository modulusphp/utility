<?php

namespace Modulus\Utility;

use Modulus\Utility\Accessor;

class View
{
  /**
   * Make a view
   *
   * @param  string $path
   * @param  array  $data
   * @return void
   */
  public static function make(string $path, array $data = [], bool $return = false)
  {
    $path = self::getPath($path);
    return Accessor::view($path, $data, $return);
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