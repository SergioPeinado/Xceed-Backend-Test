<?php

namespace App\Tests\XceedTweetConverter\Application\SaveTweetWhenItWasConverted;

use App\Tests\XceedTweetConverter\Domain\Mother\TweetMother;
use App\XceedTweetConverter\Application\SaveTweetWhenItWasConverted\SaveTweetWhenItWasConverted;
use App\XceedTweetConverter\Domain\Helpers\CacheHelper;
use App\XceedTweetConverter\Domain\Model\Tweet;
use PHPUnit\Framework\TestCase;

class SaveTweetWhenItWasConvertedTest extends TestCase
{
    private CacheHelper $cacheHelperMock;
    private SaveTweetWhenItWasConverted $saveTweetWhenItWasConverted;

    protected function setUp(): void
    {
        $this->cacheHelperMock = $this->createMock(CacheHelper::class);

        $this->saveTweetWhenItWasConverted = new SaveTweetWhenItWasConverted($this->cacheHelperMock);
    }

    public function testExecuteWithValidTweets()
    {
        $userId = 'jackDorsey';
        $tweetsArray = [
            TweetMother::create($userId, 'sample tweet text one'),
            TweetMother::create($userId, 'sample tweet text two')
        ];

        $this->cacheHelperMock->expects($this->exactly(2))
            ->method('saveTweets')
            ->with($this->callback(function (Tweet $tweet) use ($userId) {
                return $tweet->getUserName() === $userId;
            }));

        $this->saveTweetWhenItWasConverted->execute($userId, $tweetsArray);
    }

    public function testExecuteWithEmptyTweets()
    {
        $userId = 'jackDorsey';
        $tweetsArray = [];

        $this->cacheHelperMock->expects($this->never())
            ->method('saveTweets');

        $this->saveTweetWhenItWasConverted->execute($userId, $tweetsArray);
    }
}