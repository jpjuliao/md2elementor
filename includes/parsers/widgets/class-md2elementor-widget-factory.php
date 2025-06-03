<?php
/**
 * Widget Factory Interface
 *
 * @package MD2Elementor
 */

interface MD2Elementor_Widget_Factory {
    public function create(array $attributes): array;
} 