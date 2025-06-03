<?php

namespace JPJuliao\MD2Elementor\Interfaces;

/**
 * Widget factory interface
 *
 * @package JPJuliao\MD2Elementor\Interfaces
 */
interface WidgetFactoryInterface
{
    public function create(array $attributes): array;
}
