<?php
/**
 * Row Parser
 *
 * @package MD2Elementor
 */

class MD2Elementor_Row_Parser extends MD2Elementor_Base_Parser {
    private $column_parser;

    public function __construct(MD2Elementor_Column_Parser $column_parser) {
        $this->column_parser = $column_parser;
    }

    public function parse_rows($lines) {
        $rows = [];
        $current_row = null;
        $row_content = [];

        foreach ($lines as $line) {
            if (preg_match('/^::: row(\s+\[(.*)\])?$/', $line, $matches)) {
                if ($current_row !== null) {
                    $rows[] = $this->create_row($row_content);
                    $row_content = [];
                }
                $current_row = isset($matches[2]) ? $this->parse_attributes($matches[2]) : [];
            } elseif (trim($line) === ':::' && $current_row !== null) {
                $rows[] = $this->create_row($row_content);
                $current_row = null;
                $row_content = [];
            } elseif ($current_row !== null) {
                $row_content[] = $line;
            }
        }

        return $rows;
    }

    private function create_row($content) {
        return [
            'id' => MD2Elementor_ID_Generator::get_instance()->generate(),
            'elType' => 'container',
            'settings' => [],
            'elements' => $this->column_parser->parse_columns($content),
            'isInner' => true
        ];
    }
} 