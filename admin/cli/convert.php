<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use JPJuliao\MD2Elementor\Parser;

// Check if file argument is provided
if ($argc < 2) {
  echo "Usage: php convert.php <markdown_file> [output_file]\n";
  exit(1);
}

$input_file = $argv[1];
$output_file = $argc > 2 ? $argv[2] : str_replace('.md', '.json', $input_file);

// Check if input file exists
if (!file_exists($input_file)) {
  echo "Error: Input file '{$input_file}' not found.\n";
  exit(1);
}

// Read markdown content
$markdown_content = file_get_contents($input_file);

// Initialize parser and convert content
$parser = new Parser();

try {
  $elementor_data = $parser->parse($markdown_content);
  $json = json_encode($elementor_data, JSON_PRETTY_PRINT);

  // Save to output file
  file_put_contents($output_file, $json);
  echo "Successfully converted {$input_file} to {$output_file}\n";
} catch (Exception $e) {
  echo "Error: " . $e->getMessage() . "\n";
  exit(1);
}
