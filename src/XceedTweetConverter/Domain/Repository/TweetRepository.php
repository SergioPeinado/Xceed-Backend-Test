<?php

namespace App\XceedTweetConverter\Domain\Repository;

use App\XceedTweetConverter\Domain\Model\Tweet;

interface TweetRepository
{
    public function findTweetsByUser(string $userName, int $limit): array;
    public function saveTweet(Tweet $tweet): void;
    public function removeTweets(string $userName): void;
}