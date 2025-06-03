<?php
/**
 * Widget Parser
 *
 * @package MD2Elementor
 */

class MD2Elementor_Widget_Parser extends MD2Elementor_Base_Parser {
    private $widget_factories = [];

    public function __construct() {
        $this->register_widget_factories();
    }

    private function register_widget_factories() {
        $this->widget_factories = [
            'heading' => new MD2Elementor_Heading_Widget_Factory(),
            'text' => new MD2Elementor_Text_Widget_Factory(),
            'image' => new MD2Elementor_Image_Widget_Factory(),
            'button' => new MD2Elementor_Button_Widget_Factory(),
            'video' => new MD2Elementor_Video_Widget_Factory(),
            'spacer' => new MD2Elementor_Spacer_Widget_Factory(),
            'divider' => new MD2Elementor_Divider_Widget_Factory(),
        ];
    }

    public function parse_widgets($lines) {
        $widgets = [];
        $current_text = '';

        foreach ($lines as $line) {
            if (preg_match('/^(#{1,6})\s+(.*)$/', $line, $matches)) {
                if (!empty($current_text)) {
                    $widgets[] = $this->widget_factories['text']->create(['content' => $current_text]);
                    $current_text = '';
                }
                $widgets[] = $this->widget_factories['heading']->create([
                    'text' => $matches[2],
                    'level' => strlen($matches[1])
                ]);
            }
            elseif (preg_match('/^!\[(.*?)\]\((.*?)\)$/', $line, $matches)) {
                if (!empty($current_text)) {
                    $widgets[] = $this->widget_factories['text']->create(['content' => $current_text]);
                    $current_text = '';
                }
                $widgets[] = $this->widget_factories['image']->create([
                    'url' => $matches[2],
                    'alt' => $matches[1]
                ]);
            }
            elseif (preg_match('/^::: (button|video|spacer|divider)(\s+\[(.*)\])?$/', $line, $matches)) {
                if (!empty($current_text)) {
                    $widgets[] = $this->widget_factories['text']->create(['content' => $current_text]);
                    $current_text = '';
                }
                $attributes = isset($matches[3]) ? $this->parse_attributes($matches[3]) : [];
                $widgets[] = $this->widget_factories[$matches[1]]->create($attributes);
            }
            elseif (trim($line) !== ':::') {
                $current_text .= $line . "\n";
            }
        }

        if (!empty($current_text)) {
            $widgets[] = $this->widget_factories['text']->create(['content' => $current_text]);
        }

        return $widgets;
    }
} 