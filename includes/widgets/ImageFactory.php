<?php

namespace JPJuliao\MD2Elementor\Widgets;

use JPJuliao\MD2Elementor\IdGenerator;
use JPJuliao\MD2Elementor\Interfaces\WidgetFactoryInterface;

/**
 * Image factory class
 *
 * @package MD2Elementor\Widgets
 */
class ImageFactory implements WidgetFactoryInterface
{
  /**
   * Create an image
   *
   * @param array $attributes
   * @return array
   */
    public function create(array $attributes): array
    {
        return [
        'id' => IdGenerator::getInstance()->generate(),
        'elType' => 'widget',
        'widgetType' => 'image',
        'settings' => [
        'image' => [
          'url' => $attributes['url'],
          'id' => ''
        ],
        'image_alt' => $attributes['alt'] ?? ''
        ]
        ];
    }
}
