<?php

namespace App\Tests\XceedTweetConverter\Infrastructure\Persistence\Redis;

use App\Tests\XceedTweetConverter\Domain\Mother\TweetMother;
use App\XceedTweetConverter\Infrastructure\Persistence\Redis\RedisTweetRepository;
use M6Web\Component\RedisMock\RedisMockFactory;
use PHPUnit\Framework\TestCase;
use Predis\Client;

class RedisTweetRepositoryTest extends TestCase
{
    private RedisTweetRepository $repository;
    private Client $redisMock;

    protected function setUp(): void
    {
        $factory = new RedisMockFactory();
        $this->redisMock = $factory->getAdapter(Client::class);
        $this->repository = new RedisTweetRepository($this->redisMock);
    }

    public function testFindTweetsByUserWithExistingTweets()
    {
        $userName = 'jackDorsey';
        $tweets = ['First tweet', 'Second tweet', 'Third tweet'];

        foreach ($tweets as $tweet) {
            $this->redisMock->rpush($userName, $tweet);
        }

        $result = $this->repository->findTweetsByUser($userName, 2);

        $expected = ['Second tweet', 'Third tweet'];
        $this->assertEquals($expected, $result);
    }

    public function testFindTweetsByUserWithNoTweets()
    {
        $userName = 'jackDorsey';

        $this->redisMock->del($userName);

        $result = $this->repository->findTweetsByUser($userName, 3);

        $this->assertEmpty($result);
    }

    public function testSaveTweet()
    {
        $userName = 'jackDorsey';
        $tweetText = 'Sample tweet text';
        $tweet = TweetMother::create($userName, $tweetText);

        $this->repository->saveTweet($tweet);

        $savedTweets = $this->redisMock->lrange($userName, 0, -1);
        $this->assertContains($tweetText, $savedTweets[0]);
    }

    public function testRemoveTweets()
    {
        $userName = 'jackDorsey';
        $tweets = ['First tweet', 'Second tweet'];

        foreach ($tweets as $tweet) {
            $this->redisMock->rpush($userName, $tweet);
        }

        $this->repository->removeTweets($userName);

        $this->assertEmpty($this->redisMock->lrange($userName, 0, -1));
    }
}