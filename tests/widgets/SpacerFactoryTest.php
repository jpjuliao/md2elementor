<?php

namespace JPJuliao\MD2Elementor\Tests\Widgets;

use PHPUnit\Framework\TestCase;
use JPJuliao\MD2Elementor\Widgets\SpacerFactory;

/**
 * Spacer factory test class
 *
 * @package MD2Elementor\Tests\Widgets
 */
class SpacerFactoryTest extends TestCase
{
  private $factory;

  protected function setUp(): void
  {
    $this->factory = new SpacerFactory();
  }

  public function testCreateWithDefaultValues()
  {
    $spacer = $this->factory->create([]);

    $this->assertEquals('widget', $spacer['elType']);
    $this->assertEquals('spacer', $spacer['widgetType']);
    $this->assertEquals(50, $spacer['settings']['space']['size']);
  }

  public function testCreateWithCustomHeight()
  {
    $spacer = $this->factory->create([
      'height' => '100'
    ]);

    $this->assertEquals(100, $spacer['settings']['space']['size']);
  }
}
