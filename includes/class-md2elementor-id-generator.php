<?php
/**
 * Element ID Generator
 *
 * @package MD2Elementor
 */

class MD2Elementor_ID_Generator {
    private static $instance = null;
    private $element_id = 0;

    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function generate() {
        $this->element_id++;
        return (string)$this->element_id;
    }
} 