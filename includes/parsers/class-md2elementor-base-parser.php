<?php
/**
 * Base parser class with common functionality
 *
 * @package MD2Elementor
 */

abstract class MD2Elementor_Base_Parser {
    /**
     * Parse attributes from a bracket notation string
     *
     * @param string $attr_string The attribute string
     * @return array Parsed attributes
     */
    protected function parse_attributes($attr_string) {
        $attributes = [];
        preg_match_all('/(\w+)=["\'](.*?)["\']/', $attr_string, $matches, PREG_SET_ORDER);
        
        foreach ($matches as $match) {
            $attributes[$match[1]] = $match[2];
        }
        
        return $attributes;
    }
} 