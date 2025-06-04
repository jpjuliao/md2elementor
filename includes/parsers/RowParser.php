<?php

namespace JPJuliao\MD2Elementor\Parsers;

use JPJuliao\MD2Elementor\IdGenerator;

/**
 * Row parser class
 *
 * @package MD2Elementor\Parsers
 */
class RowParser extends BaseParser
{
  /**
   * Column parser
   *
   * @var ColumnParser
   */
  private $columnParser;

  /**
   * Constructor
   *
   * @param ColumnParser $columnParser
   */
  public function __construct(ColumnParser $columnParser)
  {
    $this->columnParser = $columnParser;
  }

  /**
   * Parse rows
   *
   * @param array $lines
   * @return array
   */
  public function parseRows($lines)
  {
    if (empty($lines)) {
      return [];
    }

    // If no explicit row markers, treat all content as one row
    if (!$this->hasRowMarkers($lines)) {
      return [$this->createRow($lines)];
    }

    $rows = [];
    $currentRow = null;
    $rowContent = [];

    foreach ($lines as $line) {
      if (preg_match('/^::: row(\s+\[(.*)\])?$/', $line, $matches)) {
        if ($currentRow !== null || !empty($rowContent)) {
          $rows[] = $this->createRow($rowContent);
          $rowContent = [];
        }
        $currentRow = isset($matches[2]) ? $this->parseAttributes($matches[2]) : [];
      } elseif (trim($line) === ':::' && $currentRow !== null) {
        $rows[] = $this->createRow($rowContent);
        $currentRow = null;
        $rowContent = [];
      } else {
        $rowContent[] = $line;
      }
    }

    if (!empty($rowContent)) {
      $rows[] = $this->createRow($rowContent);
    }

    return $rows;
  }

  /**
   * Check if content has row markers
   *
   * @param array $lines
   * @return bool
   */
  private function hasRowMarkers($lines)
  {
    foreach ($lines as $line) {
      if (preg_match('/^::: row(\s+\[(.*)\])?$/', $line)) {
        return true;
      }
    }
    return false;
  }

  /**
   * Create a row
   *
   * @param array $content
   * @return array
   */
  private function createRow($content)
  {
    return [
      'id' => IdGenerator::getInstance()->generate(),
      'elType' => 'container',
      'settings' => [
        'content_width' => 'full',
        'gap' => 'default',
        'gap_columns_custom' => [
          'unit' => 'px',
          'size' => '',
        ],
        'height' => 'default',
        'column_position' => 'middle',
        'content_position' => 'middle',
        'overflow' => '',
        'stretch_section' => ''
      ],
      'elements' => $this->columnParser->parseColumns($content),
      'isInner' => true
    ];
  }
}
