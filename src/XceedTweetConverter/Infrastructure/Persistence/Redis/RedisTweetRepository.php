<?php

namespace App\XceedTweetConverter\Infrastructure\Persistence\Redis;

use App\XceedTweetConverter\Domain\Model\Tweet;
use App\XceedTweetConverter\Domain\Repository\TweetRepository;
use Predis\Client;

class RedisTweetRepository implements TweetRepository
{
    public function __construct(private readonly Client $redis)
    {}

    public function findTweetsByUser(string $userName, int $limit): array
    {
        $lengthValues = $this->redis->llen($userName);
        $start = max(0, $lengthValues - $limit);

        return $this->redis->lrange($userName, $start, $lengthValues-1);
    }

    public function saveTweet(Tweet $tweet): void
    {
        $this->redis->rpush($tweet->getUserName(), [$tweet->getText()]);
    }

    public function removeTweets(string $userName): void
    {
        $this->redis->del($userName);
    }
}