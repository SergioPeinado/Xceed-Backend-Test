<?php

namespace App\Tests\XceedTweetConverter\Infrastructure\Helpers;

use App\Tests\XceedTweetConverter\Domain\Mother\TweetMother;
use App\XceedTweetConverter\Infrastructure\Helpers\RedisCacheHelper;
use App\XceedTweetConverter\Infrastructure\Persistence\Redis\RedisTweetRepository;
use PHPUnit\Framework\TestCase;

class RedisCacheHelperTest extends TestCase
{
    private RedisTweetRepository $redisTweetRepositoryMock;
    private RedisCacheHelper $redisCacheHelper;

    protected function setUp(): void
    {
        $this->redisTweetRepositoryMock = $this->createMock(RedisTweetRepository::class);

        $this->redisCacheHelper = new RedisCacheHelper($this->redisTweetRepositoryMock);
    }

    public function testFindTweets()
    {
        $userName = 'jackDorsey';
        $limit = 5;
        $expectedTweets = [
            TweetMother::create($userName, 'text')
        ];

        $this->redisTweetRepositoryMock
            ->expects($this->once())
            ->method('findTweetsByUser')
            ->with($userName, $limit)
            ->willReturn($expectedTweets);

        $result = $this->redisCacheHelper->findTweets($userName, $limit);

        $this->assertEquals($expectedTweets, $result);
    }

    public function testSaveTweets()
    {
        $userName = 'jackDorsey';
        $tweet = TweetMother::create($userName, 'text');

        $this->redisTweetRepositoryMock
            ->expects($this->once())
            ->method('saveTweet')
            ->with($tweet);

        $this->redisCacheHelper->saveTweets($tweet);
    }

    public function testRemoveTweetsByUsername()
    {
        $username = 'jackDorsey';

        $this->redisTweetRepositoryMock
            ->expects($this->once())
            ->method('removeTweets')
            ->with($username);

        $this->redisCacheHelper->removeTweetsByUsername($username);
    }
}