<?php

namespace App\Tests\XceedTweetConverter\Application\Find;

use App\XceedTweetConverter\Application\Find\TweetsFinder;
use App\XceedTweetConverter\Domain\Exception\TweetLimitExceededException;
use App\XceedTweetConverter\Domain\Exception\TweetsNotFoundException;
use App\XceedTweetConverter\Domain\Helpers\CacheHelper;
use App\XceedTweetConverter\Domain\Model\Tweet;
use App\XceedTweetConverter\Domain\Repository\TweetRepository;
use PHPUnit\Framework\TestCase;

class TweetsFinderTest extends TestCase
{
    private TweetRepository $tweetRepository;
    private CacheHelper $cacheHelper;
    private TweetsFinder $tweetsFinder;

    protected function setUp(): void
    {
        $this->tweetRepository = $this->createMock(TweetRepository::class);
        $this->cacheHelper = $this->createMock(CacheHelper::class);
        $this->tweetsFinder = new TweetsFinder($this->tweetRepository, $this->cacheHelper);
    }

    public function testLimitExceededException(): void
    {
        $this->expectException(TweetLimitExceededException::class);

        $this->tweetsFinder->findTweetsByUser('jack', 11);
    }

    public function testTweetsFoundInCache(): void
    {
        $tweets = ['This is a tweet', 'This is another tweet'];

        $this->cacheHelper->method('findTweets')
            ->willReturn($tweets);

        $this->tweetRepository->expects($this->never())
            ->method('findTweetsByUser');

        $result = $this->tweetsFinder->findTweetsByUser('jack', 2);

        $this->assertCount(2, $result);
        $this->assertInstanceOf(Tweet::class, $result[0]);
        $this->assertEquals('This is a tweet', $result[0]->getText());
    }

    public function testTweetsFoundInRepositoryWhenCacheIsEmpty(): void
    {
        $this->cacheHelper->method('findTweets')
            ->willReturn([]);

        $tweets = ['This is a tweet from repo', 'Another tweet from repo'];

        $this->tweetRepository->method('findTweetsByUser')
            ->willReturn($tweets);

        $result = $this->tweetsFinder->findTweetsByUser('jack', 2);

        $this->assertCount(2, $result);
        $this->assertInstanceOf(Tweet::class, $result[0]);
        $this->assertEquals('This is a tweet from repo', $result[0]->getText());
    }

    public function testTweetsNotFoundException(): void
    {
        $this->cacheHelper->method('findTweets')
            ->willReturn([]);

        $this->tweetRepository->method('findTweetsByUser')
            ->willReturn([]);

        $this->expectException(TweetsNotFoundException::class);

        $this->tweetsFinder->findTweetsByUser('jack', 2);
    }
}