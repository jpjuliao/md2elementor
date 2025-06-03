<?php

namespace JPJuliao\MD2Elementor;

/**
 * Autoloader class
 *
 * @package MD2Elementor
 */
class Autoloader
{
  /**
   * Register the autoloader
   */
    public static function register()
    {
        spl_autoload_register(function ($class) {
            $prefix = 'JPJuliao\\MD2Elementor\\';
            $base_dir = __DIR__ . '/';

            $len = strlen($prefix);
            if (strncmp($prefix, $class, $len) !== 0) {
                return;
            }

            $relative_class = substr($class, $len);
            $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

            if (file_exists($file)) {
                require $file;
            }
        });
    }
}
