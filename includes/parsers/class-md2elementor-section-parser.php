<?php
/**
 * Section Parser
 *
 * @package MD2Elementor
 */

class MD2Elementor_Section_Parser extends MD2Elementor_Base_Parser {
    private $row_parser;

    public function __construct(MD2Elementor_Row_Parser $row_parser) {
        $this->row_parser = $row_parser;
    }

    public function parse_sections($lines) {
        $sections = [];
        $current_section = null;
        $section_content = [];

        foreach ($lines as $line) {
            if (preg_match('/^::: section(\s+\[(.*)\])?$/', $line, $matches)) {
                if ($current_section !== null) {
                    $sections[] = $this->create_section($section_content, $current_section);
                    $section_content = [];
                }
                $current_section = isset($matches[2]) ? $this->parse_attributes($matches[2]) : [];
            } elseif (trim($line) === ':::' && $current_section !== null) {
                $sections[] = $this->create_section($section_content, $current_section);
                $current_section = null;
                $section_content = [];
            } elseif ($current_section !== null) {
                $section_content[] = $line;
            }
        }

        if ($current_section !== null) {
            $sections[] = $this->create_section($section_content, $current_section);
        }

        return $sections;
    }

    private function create_section($content, $attributes) {
        return [
            'id' => MD2Elementor_ID_Generator::get_instance()->generate(),
            'elType' => 'section',
            'settings' => $this->parse_section_settings($attributes),
            'elements' => $this->row_parser->parse_rows($content),
            'isInner' => false
        ];
    }

    private function parse_section_settings($attributes) {
        $settings = [];
        
        if (isset($attributes['class'])) {
            $settings['_css_classes'] = $attributes['class'];
        }
        
        if (isset($attributes['background'])) {
            $settings['background_background'] = 'classic';
            $settings['background_color'] = $attributes['background'];
        }
        
        if (isset($attributes['padding'])) {
            $padding = explode(' ', $attributes['padding']);
            $settings['padding'] = [
                'top' => $padding[0] ?? '0',
                'right' => $padding[1] ?? '0',
                'bottom' => $padding[2] ?? '0',
                'left' => $padding[3] ?? '0',
                'unit' => 'px',
                'isLinked' => false
            ];
        }
        
        return $settings;
    }
} 