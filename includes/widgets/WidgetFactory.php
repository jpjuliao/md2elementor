<?php

namespace MD2Elementor\Widgets;

/**
 * Widget factory interface
 *
 * @package MD2Elementor\Widgets
 */
interface WidgetFactory
{
  /**
   * Create a widget
   *
   * @param array $attributes
   * @return array
   */
  public function create(array $attributes): array;
}
