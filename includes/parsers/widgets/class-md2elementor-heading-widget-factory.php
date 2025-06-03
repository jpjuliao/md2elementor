<?php
/**
 * Heading Widget Factory
 *
 * @package MD2Elementor
 */

class MD2Elementor_Heading_Widget_Factory implements MD2Elementor_Widget_Factory {
    public function create(array $attributes): array {
        return [
            'id' => MD2Elementor_ID_Generator::get_instance()->generate(),
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