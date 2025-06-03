<?php

namespace MD2Elementor\Widgets;

use MD2Elementor\IdGenerator;

/**
 * Spacer factory class
 *
 * @package MD2Elementor\Widgets
 */
class SpacerFactory implements WidgetFactory
{

  /**
   * Create a spacer
   *
   * @param array $attributes
   * @return array
   */
  public function create(array $attributes): array
  {
    return [
      'id' => IdGenerator::getInstance()->generate(),
      'elType' => 'widget',
      'widgetType' => 'spacer',
      'settings' => [
        'space' => [
          'size' => intval($attributes['height'] ?? 50)
        ]
      ]
    ];
  }
}
