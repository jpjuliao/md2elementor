<?php

namespace JPJuliao\MD2Elementor\Tests\Parsers;

use PHPUnit\Framework\TestCase;
use JPJuliao\MD2Elementor\Parsers\WidgetParser;

/**
 * Widget parser test class
 *
 * @package MD2Elementor\Tests\Parsers
 */
class WidgetParserTest extends TestCase
{
  private $parser;

  protected function setUp(): void
  {
    $this->parser = new WidgetParser();
  }

  public function testParseHeading()
  {
    $lines = ['# Hello World'];
    $widgets = $this->parser->parseWidgets($lines);

    $this->assertCount(1, $widgets);
    $this->assertEquals('heading', $widgets[0]['widgetType']);
    $this->assertEquals('Hello World', $widgets[0]['settings']['title']);
    $this->assertEquals('h1', $widgets[0]['settings']['header_size']);
  }

  public function testParseImage()
  {
    $lines = ['![Alt text](https://example.com/image.jpg)'];
    $widgets = $this->parser->parseWidgets($lines);

    $this->assertCount(1, $widgets);
    $this->assertEquals('image', $widgets[0]['widgetType']);
    $this->assertEquals('https://example.com/image.jpg', $widgets[0]['settings']['image']['url']);
    $this->assertEquals('Alt text', $widgets[0]['settings']['image_alt']);
  }

  public function testParseButton()
  {
    $lines = [':::button [text="Click Me"][link="https://example.com"][style="primary"]'];
    $widgets = $this->parser->parseWidgets($lines);

    $this->assertCount(1, $widgets);
    $this->assertEquals('button', $widgets[0]['widgetType']);
    $this->assertEquals('Click Me', $widgets[0]['settings']['text']);
    $this->assertEquals('https://example.com', $widgets[0]['settings']['url']);
    $this->assertEquals('primary', $widgets[0]['settings']['button_type']);
  }

  public function testParseText()
  {
    $lines = ['This is a paragraph'];
    $widgets = $this->parser->parseWidgets($lines);

    $this->assertCount(1, $widgets);
    $this->assertEquals('text-editor', $widgets[0]['widgetType']);
    $this->assertEquals('This is a paragraph', trim($widgets[0]['settings']['editor']));
  }

  public function testParseMixedContent()
  {
    $lines = [
      '# Title',
      'Paragraph 1',
      '![Image](image.jpg)',
      'Paragraph 2'
    ];

    $widgets = $this->parser->parseWidgets($lines);

    $this->assertCount(4, $widgets);
    $this->assertEquals('heading', $widgets[0]['widgetType']);
    $this->assertEquals('text-editor', $widgets[1]['widgetType']);
    $this->assertEquals('image', $widgets[2]['widgetType']);
    $this->assertEquals('text-editor', $widgets[3]['widgetType']);
  }
}
