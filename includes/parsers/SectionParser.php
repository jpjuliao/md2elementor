<?php

namespace JPJuliao\MD2Elementor\Parsers;

use JPJuliao\MD2Elementor\IdGenerator;

/**
 * Section parser class
 *
 * @package MD2Elementor\Parsers
 */
class SectionParser extends BaseParser
{
  /**
   * Row parser
   *
   * @var RowParser
   */
  private $rowParser;

  /**
   * Constructor
   *
   * @param RowParser $rowParser
   */
  public function __construct(RowParser $rowParser)
  {
    $this->rowParser = $rowParser;
  }

  public function parseSections($lines)
  {
    $sections = [];
    $currentSection = null;
    $sectionContent = [];

    foreach ($lines as $line) {
      if (preg_match('/^::: section(\s+\[(.*)\])?$/', $line, $matches)) {
        if ($currentSection !== null || !empty($sectionContent)) {
          $sections[] = $this->createSection($sectionContent, $currentSection ?? []);
          $sectionContent = [];
        }
        $currentSection = isset($matches[2]) ? $this->parseAttributes($matches[2]) : [];
      } elseif (trim($line) === ':::' && $currentSection !== null) {
        $sections[] = $this->createSection($sectionContent, $currentSection);
        $currentSection = null;
        $sectionContent = [];
      } else {
        $sectionContent[] = $line;
      }
    }

    // If we have content but no sections, create a default section
    if (empty($sections) && !empty($sectionContent)) {
      $sections[] = $this->createSection($sectionContent, []);
    } elseif ($currentSection !== null || !empty($sectionContent)) {
      $sections[] = $this->createSection($sectionContent, $currentSection ?? []);
    }

    return $sections;
  }

  /**
   * Create a section
   *
   * @param array $content
   * @param array $attributes
   * @return array
   */
  private function createSection($content, $attributes)
  {
    return [
      'id' => IdGenerator::getInstance()->generate(),
      'elType' => 'section',
      'settings' => $this->parseSectionSettings($attributes),
      'elements' => $this->rowParser->parseRows($content),
      'isInner' => false
    ];
  }

  /**
   * Parse section settings
   *
   * @param array $attributes
   * @return array
   */
  private function parseSectionSettings($attributes)
  {
    $settings = [
      'layout' => 'full_width',
      'gap' => 'default',
      'height' => 'default',
      'custom_height' => [
        'unit' => 'px',
        'size' => ''
      ],
      'column_position' => 'middle',
      'content_position' => 'middle',
      'overflow' => '',
      'stretch_section' => '',
      'html_tag' => 'div',
      'background_background' => 'classic'
    ];

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
