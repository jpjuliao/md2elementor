<?php

namespace MD2Elementor\Parsers;

use MD2Elementor\Widgets\WidgetFactory;
use MD2Elementor\Widgets\HeadingFactory;
use MD2Elementor\Widgets\TextFactory;
use MD2Elementor\Widgets\ImageFactory;
use MD2Elementor\Widgets\ButtonFactory;
use MD2Elementor\Widgets\VideoFactory;
use MD2Elementor\Widgets\SpacerFactory;
use MD2Elementor\Widgets\DividerFactory;

/**
 * Widget parser class
 *
 * @package MD2Elementor\Parsers
 */
class WidgetParser extends BaseParser
{

  /**
   * Widget factories
   *
   * @var array
   */
  private $widgetFactories = [];

  /**
   * Constructor
   */
  public function __construct()
  {
    $this->registerWidgetFactories();
  }

  /**
   * Register widget factories
   */
  private function registerWidgetFactories()
  {
    $this->widgetFactories = [
      'heading' => new HeadingFactory(),
      'text' => new TextFactory(),
      'image' => new ImageFactory(),
      'button' => new ButtonFactory(),
      'video' => new VideoFactory(),
      'spacer' => new SpacerFactory(),
      'divider' => new DividerFactory(),
    ];
  }

  /**
   * Parse widgets
   *
   * @param array $lines
   * @return array
   */
  public function parseWidgets($lines)
  {
    $widgets = [];
    $currentText = '';

    foreach ($lines as $line) {
      if (preg_match('/^(#{1,6})\s+(.*)$/', $line, $matches)) {
        if (!empty($currentText)) {
          $widgets[] = $this->widgetFactories['text']->create(['content' => $currentText]);
          $currentText = '';
        }
        $widgets[] = $this->widgetFactories['heading']->create([
          'text' => $matches[2],
          'level' => strlen($matches[1])
        ]);
      } elseif (preg_match('/^!\[(.*?)\]\((.*?)\)$/', $line, $matches)) {
        if (!empty($currentText)) {
          $widgets[] = $this->widgetFactories['text']->create(['content' => $currentText]);
          $currentText = '';
        }
        $widgets[] = $this->widgetFactories['image']->create([
          'url' => $matches[2],
          'alt' => $matches[1]
        ]);
      } elseif (preg_match('/^::: (button|video|spacer|divider)(\s+\[(.*)\])?$/', $line, $matches)) {
        if (!empty($currentText)) {
          $widgets[] = $this->widgetFactories['text']->create(['content' => $currentText]);
          $currentText = '';
        }
        $attributes = isset($matches[3]) ? $this->parseAttributes($matches[3]) : [];
        $widgets[] = $this->widgetFactories[$matches[1]]->create($attributes);
      } elseif (trim($line) !== ':::') {
        $currentText .= $line . "\n";
      }
    }

    if (!empty($currentText)) {
      $widgets[] = $this->widgetFactories['text']->create(['content' => $currentText]);
    }

    return $widgets;
  }
}
