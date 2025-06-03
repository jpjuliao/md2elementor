<?php

namespace JPJuliao\MD2Elementor\Widgets;

use JPJuliao\MD2Elementor\IdGenerator;
use JPJuliao\MD2Elementor\Interfaces\WidgetFactoryInterface;

/**
 * Video factory class
 *
 * @package MD2Elementor\Widgets
 */
class VideoFactory implements WidgetFactoryInterface
{

  /**
   * Create a video
   *
   * @param array $attributes
   * @return array
   */
  public function create(array $attributes): array
  {
    return [
      'id' => IdGenerator::getInstance()->generate(),
      'elType' => 'widget',
      'widgetType' => 'video',
      'settings' => [
        'video_type' => 'youtube',
        'youtube_url' => $attributes['url'] ?? ''
      ]
    ];
  }
}
