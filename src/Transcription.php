<?php

namespace Openland0\Transcription;

class Transcription
{

    public function __construct(protected array $lines)
    {
        $this->lines = $this->discardIrrelevantLines(array_map('trim', $this->lines));
    }

    public static function load(string $path): self
    {
        return new static(file($path));
    }

    public function __toString(): string
    {
        return implode("\n", $this->lines);
    }

    public function lines(): array
    {
        return array_map(
            fn($line) => new Line(...$line),
            array_chunk($this->lines, 3)
        );
    }

    private function discardIrrelevantLines(array $lines): array
    {
        return array_values(array_filter(
            $lines,
            fn($line) => Line::valid($line)
        ));
    }

    public function htmlLines()
    {
        $htmlLines = array_map(fn(Line $line) => $line->toAnchorTag(), $this->lines());

        return implode("\n", $htmlLines);
    }
}