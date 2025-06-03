<?php

namespace JPJuliao\MD2Elementor\Tests\Widgets;

use PHPUnit\Framework\TestCase;
use JPJuliao\MD2Elementor\Widgets\HeadingFactory;

/**
 * Heading factory test class
 *
 * @package JPJuliao\MD2Elementor\Tests\Widgets
 */
class HeadingFactoryTest extends TestCase
{
  private $factory;

  protected function setUp(): void
  {
    $this->factory = new HeadingFactory();
  }

  public function testCreateWithTextAndLevel()
  {
    $heading = $this->factory->create([
      'text' => 'Test Heading',
      'level' => 2
    ]);

    $this->assertEquals('widget', $heading['elType']);
    $this->assertEquals('heading', $heading['widgetType']);
    $this->assertEquals('Test Heading', $heading['settings']['title']);
    $this->assertEquals('h2', $heading['settings']['header_size']);
    $this->assertEquals('left', $heading['settings']['align']);
  }

  public function testCreateWithDefaultAlignment()
  {
    $heading = $this->factory->create([
      'text' => 'Test Heading',
      'level' => 1
    ]);

    $this->assertEquals('h1', $heading['settings']['header_size']);
    $this->assertEquals('left', $heading['settings']['align']);
  }
}
