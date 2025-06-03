<?php

namespace JPJuliao\MD2Elementor\Parsers;

use JPJuliao\MD2Elementor\IdGenerator;

/**
 * Column parser class
 *
 * @package MD2Elementor\Parsers
 */
class ColumnParser extends BaseParser
{
  /**
   * Widget parser
   *
   * @var WidgetParser
   */
    private $widgetParser;

  /**
   * Constructor
   *
   * @param WidgetParser $widgetParser
   */
    public function __construct(WidgetParser $widgetParser)
    {
        $this->widgetParser = $widgetParser;
    }

  /**
   * Parse columns
   *
   * @param array $lines
   * @return array
   */
    public function parseColumns($lines)
    {
        $columns = [];
        $currentColumn = null;
        $columnContent = [];

        foreach ($lines as $line) {
            if (preg_match('/^::: column(\s+\[(.*)\])?$/', $line, $matches)) {
                if ($currentColumn !== null) {
                    $columns[] = $this->createColumn($columnContent, $currentColumn);
                    $columnContent = [];
                }
                $currentColumn = isset($matches[2]) ? $this->parseAttributes($matches[2]) : [];
            } elseif (trim($line) === ':::' && $currentColumn !== null) {
                $columns[] = $this->createColumn($columnContent, $currentColumn);
                $currentColumn = null;
                $columnContent = [];
            } elseif ($currentColumn !== null) {
                $columnContent[] = $line;
            }
        }

        return $columns;
    }

  /**
   * Create a column
   *
   * @param array $content
   * @param array $attributes
   * @return array
   */
    private function createColumn($content, $attributes)
    {
        $width = isset($attributes['width']) ? intval($attributes['width']) : 100;

        return [
        'id' => IdGenerator::getInstance()->generate(),
        'elType' => 'column',
        'settings' => [
        '_column_size' => $width,
        '_inline_size' => null
        ],
        'elements' => $this->widgetParser->parseWidgets($content),
        'isInner' => false
        ];
    }
}
