<?php

namespace JPJuliao\MD2Elementor\Widgets;

use JPJuliao\MD2Elementor\IdGenerator;
use JPJuliao\MD2Elementor\Interfaces\WidgetFactoryInterface;

/**
 * Heading factory class
 *
 * @package MD2Elementor\Widgets
 */
class HeadingFactory implements WidgetFactoryInterface
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
