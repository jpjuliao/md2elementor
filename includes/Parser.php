<?php

namespace JPJuliao\MD2Elementor;

/**
 * Parser class
 *
 * @package MD2Elementor
 */
class Parser
{

  /**
   * Section parser
   *
   * @var SectionParser
   */
  private $sectionParser;

  /**
   * Constructor
   */
  public function __construct()
  {
    // Initialize the parser chain
    $widgetParser = new Parsers\WidgetParser();
    $columnParser = new Parsers\ColumnParser($widgetParser);
    $rowParser = new Parsers\RowParser($columnParser);
    $this->sectionParser = new Parsers\SectionParser($rowParser);
  }

  /**
   * Parse the markdown content
   *
   * @param string $markdown_content
   * @return array
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
    $template['content'] = $this->sectionParser->parse_sections($lines);

    return $template;
  }
}
