<?php

namespace JPJuliao\MD2Elementor\Widgets;

use JPJuliao\MD2Elementor\IdGenerator;
use JPJuliao\MD2Elementor\Interfaces\WidgetFactoryInterface;

/**
 * Text factory class
 *
 * @package MD2Elementor\Widgets
 */
class TextFactory implements WidgetFactoryInterface
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
