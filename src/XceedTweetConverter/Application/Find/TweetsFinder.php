<?php

namespace App\XceedTweetConverter\Application\Find;

use App\XceedTweetConverter\Domain\Exception\TweetLimitExceededException;
use App\XceedTweetConverter\Domain\Exception\TweetsNotFoundException;
use App\XceedTweetConverter\Domain\Helpers\CacheHelper;
use App\XceedTweetConverter\Domain\Model\Tweet;
use App\XceedTweetConverter\Domain\Repository\TweetRepository;

class TweetsFinder
{
    public function __construct(
        private readonly TweetRepository $inMemoryRepository,
        private readonly CacheHelper     $cacheHelper,
    )
    {}

    /**
     * @throws TweetsNotFoundException
     * @throws TweetLimitExceededException
     */
    public function findTweetsByUser(string $userName, int $limit): array
    {
        if ($limit > 10) {
            throw new TweetLimitExceededException($limit);
        }
        $tweetsToMap = $this->cacheHelper->findTweets($userName, $limit);

        if (empty($tweetsToMap) || count($tweetsToMap) < $limit) {
            $tweetsToMap = $this->inMemoryRepository->findTweetsByUser($userName, $limit);
        }

        if (empty($tweetsToMap)) {
            throw new TweetsNotFoundException($userName);
        }

        return array_map(function ($tweetContent) use ($userName) {
            return new Tweet($userName, $tweetContent);
        }, $tweetsToMap);
    }
}