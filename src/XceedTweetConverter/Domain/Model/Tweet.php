<?php

namespace App\XceedTweetConverter\Domain\Model;

final class Tweet
{
    private string $userName;
    private string $text;

    public function __construct(string $userName, string $text)
    {
        $this->userName = $userName;
        $this->text = $text;
    }

    public function getUserName(): string
    {
        return $this->userName;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function toUppercase(): void
    {
        $this->text = strtoupper($this->text);
    }
}
