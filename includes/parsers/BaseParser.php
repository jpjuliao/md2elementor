<?php

namespace MD2Elementor\Parsers;

/**
 * Base parser class
 *
 * @package MD2Elementor\Parsers
 */
abstract class BaseParser
{

  /**
   * Parse attributes from a string
   *
   * @param string $attrString
   * @return array
   */
  protected function parseAttributes($attrString)
  {
    $attributes = [];
    preg_match_all('/(\w+)=["\'](.*?)["\']/', $attrString, $matches, PREG_SET_ORDER);

    foreach ($matches as $match) {
      $attributes[$match[1]] = $match[2];
    }

    return $attributes;
  }
}
