<?php

namespace JPJuliao\MD2Elementor\Tests\Widgets;

use PHPUnit\Framework\TestCase;
use JPJuliao\MD2Elementor\Widgets\VideoFactory;

/**
 * Video factory test class
 *
 * @package MD2Elementor\Tests\Widgets
 */
class VideoFactoryTest extends TestCase
{
    private $factory;

    protected function setUp(): void
    {
        $this->factory = new VideoFactory();
    }

    public function testCreateWithDefaultValues()
    {
        $video = $this->factory->create([]);

        $this->assertEquals('widget', $video['elType']);
        $this->assertEquals('video', $video['widgetType']);
        $this->assertEquals('youtube', $video['settings']['video_type']);
        $this->assertEquals('', $video['settings']['youtube_url']);
    }

    public function testCreateWithCustomUrl()
    {
        $video = $this->factory->create([
        'url' => 'https://youtube.com/watch?v=123'
        ]);

        $this->assertEquals('https://youtube.com/watch?v=123', $video['settings']['youtube_url']);
    }
}
