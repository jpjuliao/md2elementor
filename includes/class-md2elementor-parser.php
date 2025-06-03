<?php

/**
 * Markdown DSL to Elementor JSON Parser
 *
 * @package MD2Elementor
 */

class MD2Elementor_Parser
{
  /**
   * Stores the current Elementor element ID counter
   * @var int
   */
  private $element_id = 0;

  /**
   * Stores any defined macros
   * @var array
   */
  private $macros = [];

  /**
   * Parse a Markdown DSL string into Elementor JSON
   *
   * @param string $markdown_content The markdown DSL content
   * @return array The Elementor JSON structure
   */
  public function parse($markdown_content)
  {
    // Initialize the base template structure
    $template = [
      'version' => '0.4',
      'title' => 'MD2Elementor Template',
      'type' => 'page',
      'content' => []
    ];

    $lines = explode("\n", $markdown_content);
    $sections = $this->parse_sections($lines);

    $template['content'] = $sections;
    return $template;
  }

  /**
   * Parse sections from the markdown content
   *
   * @param array $lines Array of markdown lines
   * @return array Array of section elements
   */
  private function parse_sections($lines)
  {
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

    // Handle last section if exists
    if ($current_section !== null) {
      $sections[] = $this->create_section($section_content, $current_section);
    }

    return $sections;
  }

  /**
   * Create a section element with its content
   *
   * @param array $content Section content lines
   * @param array $attributes Section attributes
   * @return array The section element structure
   */
  private function create_section($content, $attributes)
  {
    $section = [
      'id' => $this->generate_element_id(),
      'elType' => 'section',
      'settings' => $this->parse_section_settings($attributes),
      'elements' => $this->parse_rows($content),
      'isInner' => false
    ];

    return $section;
  }

  /**
   * Parse rows within a section
   *
   * @param array $lines Content lines
   * @return array Array of row elements
   */
  private function parse_rows($lines)
  {
    $rows = [];
    $current_row = null;
    $row_content = [];

    foreach ($lines as $line) {
      if (preg_match('/^::: row(\s+\[(.*)\])?$/', $line, $matches)) {
        if ($current_row !== null) {
          $rows[] = $this->create_row($row_content);
          $row_content = [];
        }
        $current_row = isset($matches[2]) ? $this->parse_attributes($matches[2]) : [];
      } elseif (trim($line) === ':::' && $current_row !== null) {
        $rows[] = $this->create_row($row_content);
        $current_row = null;
        $row_content = [];
      } elseif ($current_row !== null) {
        $row_content[] = $line;
      }
    }

    return $rows;
  }

  /**
   * Create a row element
   *
   * @param array $content Row content lines
   * @return array The row element structure
   */
  private function create_row($content)
  {
    return [
      'id' => $this->generate_element_id(),
      'elType' => 'container',
      'settings' => [],
      'elements' => $this->parse_columns($content),
      'isInner' => true
    ];
  }

  /**
   * Parse columns within a row
   *
   * @param array $lines Content lines
   * @return array Array of column elements
   */
  private function parse_columns($lines)
  {
    $columns = [];
    $current_column = null;
    $column_content = [];

    foreach ($lines as $line) {
      if (preg_match('/^::: column(\s+\[(.*)\])?$/', $line, $matches)) {
        if ($current_column !== null) {
          $columns[] = $this->create_column($column_content, $current_column);
          $column_content = [];
        }
        $current_column = isset($matches[2]) ? $this->parse_attributes($matches[2]) : [];
      } elseif (trim($line) === ':::' && $current_column !== null) {
        $columns[] = $this->create_column($column_content, $current_column);
        $current_column = null;
        $column_content = [];
      } elseif ($current_column !== null) {
        $column_content[] = $line;
      }
    }

    return $columns;
  }

  /**
   * Create a column element
   *
   * @param array $content Column content lines
   * @param array $attributes Column attributes
   * @return array The column element structure
   */
  private function create_column($content, $attributes)
  {
    $width = isset($attributes['width']) ? intval($attributes['width']) : 100;

    return [
      'id' => $this->generate_element_id(),
      'elType' => 'column',
      'settings' => [
        '_column_size' => $width,
        '_inline_size' => null
      ],
      'elements' => $this->parse_widgets($content),
      'isInner' => false
    ];
  }

  /**
   * Parse widgets within a column
   *
   * @param array $lines Content lines
   * @return array Array of widget elements
   */
  private function parse_widgets($lines)
  {
    $widgets = [];
    $current_text = '';

    foreach ($lines as $line) {
      // Handle headings
      if (preg_match('/^(#{1,6})\s+(.*)$/', $line, $matches)) {
        if (!empty($current_text)) {
          $widgets[] = $this->create_text_widget($current_text);
          $current_text = '';
        }
        $widgets[] = $this->create_heading_widget($matches[2], strlen($matches[1]));
      }
      // Handle images
      elseif (preg_match('/^!\[(.*?)\]\((.*?)\)$/', $line, $matches)) {
        if (!empty($current_text)) {
          $widgets[] = $this->create_text_widget($current_text);
          $current_text = '';
        }
        $widgets[] = $this->create_image_widget($matches[2], $matches[1]);
      }
      // Handle special widgets (button, video, spacer, divider)
      elseif (preg_match('/^::: (button|video|spacer|divider)(\s+\[(.*)\])?$/', $line, $matches)) {
        if (!empty($current_text)) {
          $widgets[] = $this->create_text_widget($current_text);
          $current_text = '';
        }
        $attributes = isset($matches[3]) ? $this->parse_attributes($matches[3]) : [];
        $widgets[] = $this->create_special_widget($matches[1], $attributes);
      }
      // Handle regular text
      elseif (trim($line) !== ':::') {
        $current_text .= $line . "\n";
      }
    }

    // Add remaining text if any
    if (!empty($current_text)) {
      $widgets[] = $this->create_text_widget($current_text);
    }

    return $widgets;
  }

  /**
   * Create a heading widget
   *
   * @param string $text Heading text
   * @param int $level Heading level (1-6)
   * @return array The heading widget structure
   */
  private function create_heading_widget($text, $level)
  {
    return [
      'id' => $this->generate_element_id(),
      'elType' => 'widget',
      'widgetType' => 'heading',
      'settings' => [
        'title' => $text,
        'header_size' => "h$level",
        'align' => 'left'
      ]
    ];
  }

  /**
   * Create a text widget
   *
   * @param string $content Text content
   * @return array The text widget structure
   */
  private function create_text_widget($content)
  {
    return [
      'id' => $this->generate_element_id(),
      'elType' => 'widget',
      'widgetType' => 'text-editor',
      'settings' => [
        'editor' => trim($content)
      ]
    ];
  }

  /**
   * Create an image widget
   *
   * @param string $url Image URL
   * @param string $alt Alt text
   * @return array The image widget structure
   */
  private function create_image_widget($url, $alt)
  {
    return [
      'id' => $this->generate_element_id(),
      'elType' => 'widget',
      'widgetType' => 'image',
      'settings' => [
        'image' => [
          'url' => $url,
          'id' => ''
        ],
        'image_alt' => $alt
      ]
    ];
  }

  /**
   * Create special widgets (button, video, spacer, divider)
   *
   * @param string $type Widget type
   * @param array $attributes Widget attributes
   * @return array The widget structure
   */
  private function create_special_widget($type, $attributes)
  {
    switch ($type) {
      case 'button':
        return [
          'id' => $this->generate_element_id(),
          'elType' => 'widget',
          'widgetType' => 'button',
          'settings' => [
            'text' => $attributes['text'] ?? 'Click Here',
            'url' => $attributes['link'] ?? '#',
            'button_type' => $attributes['style'] ?? 'default'
          ]
        ];
      case 'video':
        return [
          'id' => $this->generate_element_id(),
          'elType' => 'widget',
          'widgetType' => 'video',
          'settings' => [
            'video_type' => 'youtube',
            'youtube_url' => $attributes['url'] ?? ''
          ]
        ];
      case 'spacer':
        return [
          'id' => $this->generate_element_id(),
          'elType' => 'widget',
          'widgetType' => 'spacer',
          'settings' => [
            'space' => [
              'size' => intval($attributes['height'] ?? 50)
            ]
          ]
        ];
      case 'divider':
        return [
          'id' => $this->generate_element_id(),
          'elType' => 'widget',
          'widgetType' => 'divider',
          'settings' => [
            'style' => $attributes['style'] ?? 'solid',
            'width' => [
              'size' => intval($attributes['width'] ?? 100)
            ],
            'align' => $attributes['alignment'] ?? 'center'
          ]
        ];
      default:
        return [];
    }
  }

  /**
   * Parse attributes from a bracket notation string
   *
   * @param string $attr_string The attribute string
   * @return array Parsed attributes
   */
  private function parse_attributes($attr_string)
  {
    $attributes = [];
    preg_match_all('/(\w+)=["\'](.*?)["\']/', $attr_string, $matches, PREG_SET_ORDER);

    foreach ($matches as $match) {
      $attributes[$match[1]] = $match[2];
    }

    return $attributes;
  }

  /**
   * Parse section settings from attributes
   *
   * @param array $attributes Section attributes
   * @return array Section settings
   */
  private function parse_section_settings($attributes)
  {
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

  /**
   * Generate a unique element ID
   *
   * @return string Element ID
   */
  private function generate_element_id()
  {
    $this->element_id++;
    return (string)$this->element_id;
  }
}
