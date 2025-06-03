<?php

namespace MD2Elementor\Widgets;

use MD2Elementor\IdGenerator;

/**
 * Text factory class
 *
 * @package MD2Elementor\Widgets
 */
class TextFactory implements WidgetFactory
{

  /**
   * Create a text
   *
   * @param array $attributes
   * @return array
   */
  public function create(array $attributes): array
  {
    return [
      'id' => IdGenerator::getInstance()->generate(),
      'elType' => 'widget',
      'widgetType' => 'text-editor',
      'settings' => [
        'editor' => trim($attributes['content'])
      ]
    ];
  }
}
