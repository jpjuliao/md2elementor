<?php

namespace MD2Elementor\Widgets;

use MD2Elementor\IdGenerator;

/**
 * Video factory class
 *
 * @package MD2Elementor\Widgets
 */
class VideoFactory implements WidgetFactory
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
