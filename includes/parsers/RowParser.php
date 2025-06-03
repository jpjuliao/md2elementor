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
    $rows = [];
    $currentRow = null;
    $rowContent = [];

    foreach ($lines as $line) {
      if (preg_match('/^::: row(\s+\[(.*)\])?$/', $line, $matches)) {
        if ($currentRow !== null) {
          $rows[] = $this->createRow($rowContent);
          $rowContent = [];
        }
        $currentRow = isset($matches[2]) ? $this->parseAttributes($matches[2]) : [];
      } elseif (trim($line) === ':::' && $currentRow !== null) {
        $rows[] = $this->createRow($rowContent);
        $currentRow = null;
        $rowContent = [];
      } elseif ($currentRow !== null) {
        $rowContent[] = $line;
      }
    }

    return $rows;
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
      'settings' => [],
      'elements' => $this->columnParser->parseColumns($content),
      'isInner' => true
    ];
  }
}
