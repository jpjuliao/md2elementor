<?php

namespace JPJuliao\MD2Elementor\Parsers;

use JPJuliao\MD2Elementor\Widgets\WidgetFactory;
use JPJuliao\MD2Elementor\Widgets\HeadingFactory;
use JPJuliao\MD2Elementor\Widgets\TextFactory;
use JPJuliao\MD2Elementor\Widgets\ImageFactory;
use JPJuliao\MD2Elementor\Widgets\ButtonFactory;
use JPJuliao\MD2Elementor\Widgets\VideoFactory;
use JPJuliao\MD2Elementor\Widgets\SpacerFactory;
use JPJuliao\MD2Elementor\Widgets\DividerFactory;

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
      } elseif (preg_match('/^:::(\s+)?(button|video|spacer|divider)(\s+\[(.*)\])?$/', $line, $matches)) {
        if (!empty($currentText)) {
          $widgets[] = $this->widgetFactories['text']->create(['content' => $currentText]);
          $currentText = '';
        }
        $attributes = isset($matches[4]) ? $this->parseAttributes($matches[4]) : [];
        $widgets[] = $this->widgetFactories[$matches[2]]->create($attributes);
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
