<?php

namespace App\XceedTweetConverter\Domain\Exception;

class TweetsNotFoundException extends \Exception
{
    public function __construct(string $username)
    {
        $message = sprintf('Tweets not found for: %s', $username);
        parent::__construct($message);
    }
}