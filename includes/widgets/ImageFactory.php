<?php

namespace MD2Elementor\Widgets;

use MD2Elementor\IdGenerator;

/**
 * Image factory class
 *
 * @package MD2Elementor\Widgets
 */
class ImageFactory implements WidgetFactory
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
