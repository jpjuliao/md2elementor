<?php

namespace JPJuliao\MD2Elementor\Tests\Widgets;

use PHPUnit\Framework\TestCase;
use JPJuliao\MD2Elementor\Widgets\ImageFactory;

/**
 * Image factory test class
 *
 * @package JPJuliao\MD2Elementor\Tests\Widgets
 */
class ImageFactoryTest extends TestCase
{
  private $factory;

  protected function setUp(): void
  {
    $this->factory = new ImageFactory();
  }

  public function testCreateWithRequiredValues()
  {
    $image = $this->factory->create([
      'url' => 'https://example.com/image.jpg',
      'alt' => 'Test Image'
    ]);

    $this->assertEquals('widget', $image['elType']);
    $this->assertEquals('image', $image['widgetType']);
    $this->assertEquals('https://example.com/image.jpg', $image['settings']['image']['url']);
    $this->assertEquals('Test Image', $image['settings']['image_alt']);
    $this->assertEquals('', $image['settings']['image']['id']);
  }

  public function testCreateWithoutAltText()
  {
    $image = $this->factory->create([
      'url' => 'https://example.com/image.jpg'
    ]);

    $this->assertEquals('https://example.com/image.jpg', $image['settings']['image']['url']);
    $this->assertEquals('', $image['settings']['image_alt']);
  }
}
