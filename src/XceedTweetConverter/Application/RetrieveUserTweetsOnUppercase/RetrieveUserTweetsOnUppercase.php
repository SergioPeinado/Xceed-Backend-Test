<?php

namespace App\XceedTweetConverter\Application\RetrieveUserTweetsOnUppercase;

use App\XceedTweetConverter\Domain\Service\TweetConverter;

class RetrieveUserTweetsOnUppercase
{
    public function __construct(
        private readonly TweetConverter $converter
    ) {}

    public function execute(array $tweets): array
    {
        $convertedTweets = [];
        foreach ($tweets as $tweet) {
            $convertedTweet = $this->converter->convertToUppercase($tweet);
            $convertedTweets[] = $convertedTweet->getText();
        }

        return $convertedTweets;
    }
}
