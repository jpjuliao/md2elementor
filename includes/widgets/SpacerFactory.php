<?php

namespace JPJuliao\MD2Elementor\Widgets;

use JPJuliao\MD2Elementor\IdGenerator;
use JPJuliao\MD2Elementor\Interfaces\WidgetFactoryInterface;

/**
 * Spacer factory class
 *
 * @package MD2Elementor\Widgets
 */
class SpacerFactory implements WidgetFactoryInterface
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
