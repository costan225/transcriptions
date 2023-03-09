<?php

namespace Tests;

use Openland0\Transcription\Line;
use Openland0\Transcription\Transcription;
use PHPUnit\Framework\TestCase;

/**
 * @uses \Openland0\Transcription\Transcription
 * @covers Transcription::_construct
 */
class TranscriptionTest extends TestCase
{
    private Transcription $transaction;

    protected function setUp(): void
    {
        $file = __DIR__ . '/stubs/basic-example.vtt';

        $this->transaction = Transcription::load($file);
    }

    public function it_loads_a_vtt_file_as_a_string()
    {
        $file = __DIR__ . '/stubs/basic-example.vtt';

        $this->assertStringEqualsFile($file, $this->transaction);
    }

    /**
     * @test
     */
    public function it_can_convert_to_an_array_of_line_objects()
    {
        $lines = $this->transaction->lines();

        $this->assertCount(3, $lines);

        $this->assertContainsOnlyInstancesOf(Line::class, $lines);
    }

    /**
     * @test
     */
    public function it_discards_irrelevant_lines_from_the_vtt_file()
    {
        $this->assertStringNotContainsString('WEBVTT', $this->transaction);
    }

    /**
     * @test
     */
    public function it_renders_the_lines_as_html()
    {
        $expected = <<<EOT
<a href="?time=03.210">In this Larabit,</a>
<a href="?time=03.210">I'll give you some basic advice</a>
<a href="?time=05.630">for how to extract</a>
EOT;

        $this->assertEquals($expected, $this->transaction->htmlLines());
    }
}