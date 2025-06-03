<?php

namespace MD2Elementor\Widgets;

use MD2Elementor\IdGenerator;

/**
 * Divider factory class
 *
 * @package MD2Elementor\Widgets
 */
class DividerFactory implements WidgetFactory
{

  /**
   * Create a divider
   *
   * @param array $attributes
   * @return array
   */
  public function create(array $attributes): array
  {
    return [
      'id' => IdGenerator::getInstance()->generate(),
      'elType' => 'widget',
      'widgetType' => 'divider',
      'settings' => [
        'style' => $attributes['style'] ?? 'solid',
        'width' => [
          'size' => intval($attributes['width'] ?? 100)
        ],
        'align' => $attributes['alignment'] ?? 'center'
      ]
    ];
  }
}
