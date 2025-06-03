<?php

namespace MD2Elementor\Widgets;

use MD2Elementor\IdGenerator;

/**
 * Button factory class
 *
 * @package MD2Elementor\Widgets
 */
class ButtonFactory implements WidgetFactory
{

  /**
   * Create a button
   *
   * @param array $attributes
   * @return array
   */
  public function create(array $attributes): array
  {
    return [
      'id' => IdGenerator::getInstance()->generate(),
      'elType' => 'widget',
      'widgetType' => 'button',
      'settings' => [
        'text' => $attributes['text'] ?? 'Click Here',
        'url' => $attributes['link'] ?? '#',
        'button_type' => $attributes['style'] ?? 'default'
      ]
    ];
  }
}
