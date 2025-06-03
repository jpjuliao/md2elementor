<?php

namespace JPJuliao\MD2Elementor\Widgets;

use JPJuliao\MD2Elementor\IdGenerator;
use JPJuliao\MD2Elementor\Interfaces\WidgetFactoryInterface;

/**
 * Divider factory class
 *
 * @package MD2Elementor\Widgets
 */
class DividerFactory implements WidgetFactoryInterface
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
