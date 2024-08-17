<?php

namespace App\XceedTweetConverter\Application\SaveTweetWhenItWasConverted;

use App\XceedTweetConverter\Domain\Helpers\CacheHelper;
use App\XceedTweetConverter\Domain\Model\Tweet;

class SaveTweetWhenItWasConverted
{
    public function __construct(
        private readonly CacheHelper $cacheHelper,
    ) {}

    public function execute(string $userId, array $tweets): void
    {
        foreach ($tweets as $tweet) {
            /** @var Tweet $tweet */
            $tweet = new Tweet($userId, $tweet->getText());
            $this->cacheHelper->saveTweets($tweet);
        }
    }
}
