<?php

namespace App\XceedTweetConverter\Domain\Helpers;

use App\XceedTweetConverter\Domain\Model\Tweet;

interface CacheHelper
{
    public function findTweets(string $userName, int $limit): array;

    public function saveTweets(Tweet $tweet): void;

    public function removeTweetsByUsername(string $username): void;
}