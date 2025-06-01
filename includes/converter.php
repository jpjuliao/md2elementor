<?php

namespace jpjuliao\md2elementor;

function parse_markdown_to_elementor_json($markdown)
{
  // Step 1: Very simple regex parser (not a full Markdown parser)
  $lines = preg_split('/\r\n|\r|\n/', $markdown);
  $stack = [];
  $output = [];
  $id_counter = 1;

  foreach ($lines as $line) {
    $trim = trim($line);

    if (preg_match('/^:::\s*(section|row|column)/', $trim, $matches)) {
      $stack[] = [
        'type' => $matches[1],
        'elements' => [],
        'id' => uniqid("{$matches[1]}_")
      ];
    } elseif (preg_match('/^:::/', $trim)) {
      $closed = array_pop($stack);
      if (empty($stack)) {
        $output[] = $closed;
      } else {
        $stack[count($stack) - 1]['elements'][] = $closed;
      }
    } elseif (preg_match('/^#\s+(.*)/', $trim, $matches)) {
      $stack[count($stack) - 1]['elements'][] = [
        'type' => 'heading',
        'level' => 1,
        'content' => $matches[1],
        'id' => uniqid("heading_")
      ];
    } elseif (preg_match('/!\[.*\]\((.*?)\)/', $trim, $matches)) {
      $stack[count($stack) - 1]['elements'][] = [
        'type' => 'image',
        'src' => $matches[1],
        'id' => uniqid("image_")
      ];
    }
  }

  // Step 2: Convert parsed array to Elementor JSON
  return array_map('convert_to_elementor_json', $output);
}

function convert_to_elementor_json($block)
{
  if ($block['type'] === 'section') {
    return [
      'id' => $block['id'],
      'elType' => 'section',
      'settings' => [],
      'elements' => array_map('convert_to_elementor_json', $block['elements']),
    ];
  }

  if ($block['type'] === 'column') {
    return [
      'id' => $block['id'],
      'elType' => 'column',
      'settings' => ['_column_size' => 50],
      'elements' => array_map('convert_to_elementor_json', $block['elements']),
    ];
  }

  if ($block['type'] === 'heading') {
    return [
      'id' => $block['id'],
      'elType' => 'widget',
      'widgetType' => 'heading',
      'settings' => [
        'title' => $block['content'],
        'header_size' => 'h1'
      ],
      'elements' => [],
    ];
  }

  if ($block['type'] === 'image') {
    return [
      'id' => $block['id'],
      'elType' => 'widget',
      'widgetType' => 'image',
      'settings' => [
        'image' => ['url' => $block['src']],
        'caption_source' => 'none'
      ],
      'elements' => [],
    ];
  }

  // If it's a row, skip nesting (Elementor only supports sections → columns → widgets)
  if ($block['type'] === 'row') {
    return array_map('convert_to_elementor_json', $block['elements']);
  }

  return [];
}
