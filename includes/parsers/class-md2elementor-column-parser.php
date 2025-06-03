<?php
/**
 * Column Parser
 *
 * @package MD2Elementor
 */

class MD2Elementor_Column_Parser extends MD2Elementor_Base_Parser {
    private $widget_parser;

    public function __construct(MD2Elementor_Widget_Parser $widget_parser) {
        $this->widget_parser = $widget_parser;
    }

    public function parse_columns($lines) {
        $columns = [];
        $current_column = null;
        $column_content = [];

        foreach ($lines as $line) {
            if (preg_match('/^::: column(\s+\[(.*)\])?$/', $line, $matches)) {
                if ($current_column !== null) {
                    $columns[] = $this->create_column($column_content, $current_column);
                    $column_content = [];
                }
                $current_column = isset($matches[2]) ? $this->parse_attributes($matches[2]) : [];
            } elseif (trim($line) === ':::' && $current_column !== null) {
                $columns[] = $this->create_column($column_content, $current_column);
                $current_column = null;
                $column_content = [];
            } elseif ($current_column !== null) {
                $column_content[] = $line;
            }
        }

        return $columns;
    }

    private function create_column($content, $attributes) {
        $width = isset($attributes['width']) ? intval($attributes['width']) : 100;
        
        return [
            'id' => MD2Elementor_ID_Generator::get_instance()->generate(),
            'elType' => 'column',
            'settings' => [
                '_column_size' => $width,
                '_inline_size' => null
            ],
            'elements' => $this->widget_parser->parse_widgets($content),
            'isInner' => false
        ];
    }
} 