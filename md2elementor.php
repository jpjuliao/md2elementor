<?php

/**
 * Plugin Name: Markdown 2 Elementor
 * Plugin URI: https://github.com/jpjuliao/md2elementor
 * Description: Converts Markdown to Elementor layouts.
 * Version: 1.0.0
 * Author: Juan Pablo Juliao
 * Author URI: https://github.com/jpjuliao
 * License: MIT
 * Text Domain: md2elementor
 */

if (!defined('ABSPATH')) {
    exit;
}

require_once __DIR__ . '/includes/Autoloader.php';

use JPJuliao\MD2Elementor\Autoloader;
use JPJuliao\MD2Elementor\Parser;

Autoloader::register();

$parser = new Parser();
return $parser->parse($markdown_content);
