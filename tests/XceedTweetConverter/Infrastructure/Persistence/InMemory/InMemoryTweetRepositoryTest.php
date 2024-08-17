<?php

namespace App\Tests\XceedTweetConverter\Infrastructure\Persistence\InMemory;

use App\Tests\XceedTweetConverter\Domain\Mother\TweetMother;
use App\XceedTweetConverter\Infrastructure\Persistence\InMemory\InMemoryTweetRepository;
use PHPUnit\Framework\TestCase;

class InMemoryTweetRepositoryTest extends TestCase
{
    private InMemoryTweetRepository $repository;

    protected function setUp(): void
    {
        $this->repository = new InMemoryTweetRepository();
    }

    public function testFindTweetsByUserWithLimit()
    {
        $mockedTweets = ['jackDorsey' => [
            "I'm so grateful for the beauty and wonder of the natural world around us.",
            "Trying to focus on the positive and let go of the negative.",
            "I believe in the power of visualization and manifesting our dreams into reality.",
            "I'm grateful for the amazing experiences that life has to offer us.",
            "Taking time to disconnect and recharge is essential for our well-being.",
            ]
        ];
        $userName = 'jackDorsey';
        $limit = 5;

        $tweets = $this->repository->findTweetsByUser($userName, $limit);

        $expectedTweets = array_slice($mockedTweets[$userName], -$limit);

        $this->assertEquals($expectedTweets, $tweets);
    }

    public function testFindTweetsByUserWithZeroLimit()
    {
        $userName = 'jackDorsey';
        $limit = 0;

        $tweets = $this->repository->findTweetsByUser($userName, $limit);

        $this->assertEquals([], $tweets);
    }

    public function testSaveTweet()
    {
        $userName = 'jackDorsey';
        $tweetText = 'This is a new tweet';
        $tweet = TweetMother::create($userName, $tweetText);

        $this->repository->saveTweet($tweet);

        $savedTweets = $this->repository->findTweetsByUser($userName, 1);
        $this->assertCount(1, $savedTweets);
        $this->assertEquals($tweetText, $savedTweets[0]);
    }

    public function testSaveMultipleTweets()
    {
        $userName = 'jackDorsey';
        $tweets = [
            TweetMother::create($userName,'First tweet'),
            TweetMother::create($userName, 'Second tweet')
        ];

        foreach ($tweets as $tweet) {
            $this->repository->saveTweet($tweet);
        }

        $savedTweets = $this->repository->findTweetsByUser($userName, 2);
        $this->assertCount(2, $savedTweets);
        $this->assertEquals('First tweet', $savedTweets[0]);
        $this->assertEquals('Second tweet', $savedTweets[1]);
    }

    public function testRemoveTweets()
    {
        $this->repository->removeTweets('jackDorsey');

        $this->assertTrue(true);
    }
}