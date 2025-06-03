<?php

namespace JPJuliao\MD2Elementor\Tests\Widgets;

use PHPUnit\Framework\TestCase;
use JPJuliao\MD2Elementor\Widgets\DividerFactory;

/**
 * Divider factory test class
 *
 * @package MD2Elementor\Tests\Widgets
 */
class DividerFactoryTest extends TestCase
{
  private $factory;

  protected function setUp(): void
  {
    $this->factory = new DividerFactory();
  }

  public function testCreateWithDefaultValues()
  {
    $divider = $this->factory->create([]);

    $this->assertEquals('widget', $divider['elType']);
    $this->assertEquals('divider', $divider['widgetType']);
    $this->assertEquals('solid', $divider['settings']['style']);
    $this->assertEquals(100, $divider['settings']['width']['size']);
    $this->assertEquals('center', $divider['settings']['align']);
  }

  public function testCreateWithCustomValues()
  {
    $divider = $this->factory->create([
      'style' => 'dashed',
      'width' => '50',
      'alignment' => 'left'
    ]);

    $this->assertEquals('dashed', $divider['settings']['style']);
    $this->assertEquals(50, $divider['settings']['width']['size']);
    $this->assertEquals('left', $divider['settings']['align']);
  }
}
