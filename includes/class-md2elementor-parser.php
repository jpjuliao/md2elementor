<?php

/**
 * Markdown DSL to Elementor JSON Parser
 *
 * @package MD2Elementor
 */

class MD2Elementor_Parser
{
  private $section_parser;

  public function __construct() {
    // Initialize the parser chain
    $widget_parser = new MD2Elementor_Widget_Parser();
    $column_parser = new MD2Elementor_Column_Parser($widget_parser);
    $row_parser = new MD2Elementor_Row_Parser($column_parser);
    $this->section_parser = new MD2Elementor_Section_Parser($row_parser);
  }

  /**
   * Parse a Markdown DSL string into Elementor JSON
   *
   * @param string $markdown_content The markdown DSL content
   * @return array The Elementor JSON structure
   */
  public function parse($markdown_content)
  {
    $template = [
      'version' => '0.4',
      'title' => 'MD2Elementor Template',
      'type' => 'page',
      'content' => []
    ];

    $lines = explode("\n", $markdown_content);
    $template['content'] = $this->section_parser->parse_sections($lines);
    
    return $template;
  }
}
