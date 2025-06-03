<?php

namespace JPJuliao\MD2Elementor\Tests\Widgets;

use PHPUnit\Framework\TestCase;
use JPJuliao\MD2Elementor\Widgets\TextFactory;

/**
 * Text factory test class
 *
 * @package JPJuliao\MD2Elementor\Tests\Widgets
 */
class TextFactoryTest extends TestCase
{
    private $factory;

    protected function setUp(): void
    {
        $this->factory = new TextFactory();
    }

    public function testCreateWithContent()
    {
        $text = $this->factory->create([
        'content' => 'Hello World'
        ]);

        $this->assertEquals('widget', $text['elType']);
        $this->assertEquals('text-editor', $text['widgetType']);
        $this->assertEquals('Hello World', $text['settings']['editor']);
    }

    public function testCreateWithEmptyContent()
    {
        $text = $this->factory->create([
        'content' => ''
        ]);

        $this->assertEquals('text-editor', $text['widgetType']);
        $this->assertEquals('', $text['settings']['editor']);
    }
}
