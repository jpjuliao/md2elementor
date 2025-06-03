<?php
namespace JPJuliao\MD2Elementor;

/**
 * Plugin Name: Markdown 2 Elementor
 * Description: Converts Markdown to Elementor layouts.
 */

require_once __DIR__ . '/includes/Autoloader.php';

use JPJuliao\MD2Elementor\Autoloader;
use JPJuliao\MD2Elementor\Parser;

Autoloader::register();

function md2elementor_parse($markdown_content) {
    $parser = new Parser();
    return $parser->parse($markdown_content);
}
