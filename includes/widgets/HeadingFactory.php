<?php

namespace MD2Elementor\Widgets;

use MD2Elementor\IdGenerator;

/**
 * Heading factory class
 *
 * @package MD2Elementor\Widgets
 */
class HeadingFactory implements WidgetFactory
{

  /**
   * Create a heading
   *
   * @param array $attributes
   * @return array
   */
  public function create(array $attributes): array
  {
    return [
      'id' => IdGenerator::getInstance()->generate(),
      'elType' => 'widget',
      'widgetType' => 'heading',
      'settings' => [
        'title' => $attributes['text'],
        'header_size' => "h{$attributes['level']}",
        'align' => 'left'
      ]
    ];
  }
}
