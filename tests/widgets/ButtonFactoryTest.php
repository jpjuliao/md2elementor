<?php

namespace JPJuliao\MD2Elementor\Tests\Widgets;

use PHPUnit\Framework\TestCase;
use JPJuliao\MD2Elementor\Widgets\ButtonFactory;

/**
 * Button factory test class
 *
 * @package MD2Elementor\Tests\Widgets
 */
class ButtonFactoryTest extends TestCase
{
  private $factory;

  protected function setUp(): void
  {
    $this->factory = new ButtonFactory();
  }

  public function testCreateWithDefaultValues()
  {
    $button = $this->factory->create([]);

    $this->assertEquals('widget', $button['elType']);
    $this->assertEquals('button', $button['widgetType']);
    $this->assertEquals('Click Here', $button['settings']['text']);
    $this->assertEquals('#', $button['settings']['url']);
    $this->assertEquals('default', $button['settings']['button_type']);
  }

  public function testCreateWithCustomValues()
  {
    $button = $this->factory->create([
      'text' => 'Custom Button',
      'link' => 'https://example.com',
      'style' => 'primary'
    ]);

    $this->assertEquals('Custom Button', $button['settings']['text']);
    $this->assertEquals('https://example.com', $button['settings']['url']);
    $this->assertEquals('primary', $button['settings']['button_type']);
  }
}
