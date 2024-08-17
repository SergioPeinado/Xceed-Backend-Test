<?php

namespace App\XceedTweetConverter\Infrastructure\Helpers;

use App\XceedTweetConverter\Domain\Helpers\CacheHelper;
use App\XceedTweetConverter\Domain\Model\Tweet;
use App\XceedTweetConverter\Domain\Repository\TweetRepository;

class RedisCacheHelper implements CacheHelper
{
    private TweetRepository $redisRepository;

    public function __construct(TweetRepository $redisRepository)
    {
        $this->redisRepository = $redisRepository;
    }

    public function findTweets(string $userName, int $limit): array
    {
        return $this->redisRepository->findTweetsByUser($userName, $limit);
    }

    public function saveTweets(Tweet $tweet): void
    {
        $this->redisRepository->saveTweet($tweet);
    }

    public function removeTweetsByUsername(string $username): void
    {
        $this->redisRepository->removeTweets($username);
    }
}