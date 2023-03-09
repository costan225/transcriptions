<?php

namespace Openland0\Transcription;

class Line
{
    public function __construct(
        public int $position, public string $datetime, public string $message
    )
    {
    }

    public function beginningTimestamp()
    {
        preg_match('/^\d{2}:\d{2}:(\d{2}\.\d{3})/', $this->datetime, $matches);

        return $matches[1];
    }

    public function toAnchorTag(): string
    {
        return "<a href=\"?time={$this->beginningTimestamp()}\">{$this->message}</a>";
    }

    public static function valid($line)
    {
        return $line != 'WEBVTT' && !empty($line);
    }
}