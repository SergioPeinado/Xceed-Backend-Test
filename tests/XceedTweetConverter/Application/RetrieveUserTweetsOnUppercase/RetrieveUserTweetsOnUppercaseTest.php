<?php

namespace App\Tests\XceedTweetConverter\Application\RetrieveUserTweetsOnUppercase;

use App\Tests\XceedTweetConverter\Domain\Mother\TweetMother;
use App\XceedTweetConverter\Application\RetrieveUserTweetsOnUppercase\RetrieveUserTweetsOnUppercase;
use App\XceedTweetConverter\Domain\Model\Tweet;
use App\XceedTweetConverter\Domain\Service\TweetConverter;
use PHPUnit\Framework\TestCase;

class RetrieveUserTweetsOnUppercaseTest extends TestCase
{
    private TweetConverter $converterMock;
    private RetrieveUserTweetsOnUppercase $retrieveUserTweetsOnUppercase;

    protected function setUp(): void
    {
        $this->converterMock = $this->createMock(TweetConverter::class);

        $this->retrieveUserTweetsOnUppercase = new RetrieveUserTweetsOnUppercase($this->converterMock);
    }

    public function testExecuteWithValidTweets()
    {
        $tweets = [TweetMother::create('jackDorsey', 'tweet one'), TweetMother::create('jackDorsey', 'tweet two')];
        $convertedTweets = ['TWEET ONE', 'TWEET TWO'];

        $this->converterMock->expects($this->at(0))->method('convertToUppercase')->willReturn(TweetMother::create('jackDorsey', 'TWEET ONE'));
        $this->converterMock->expects($this->at(1))->method('convertToUppercase')->willReturn(TweetMother::create('jackDorsey', 'TWEET TWO'));

        $result = $this->retrieveUserTweetsOnUppercase->execute($tweets);

        $this->assertEquals($convertedTweets, $result);
    }

    public function testExecuteWithEmptyTweets()
    {
        $result = $this->retrieveUserTweetsOnUppercase->execute([]);

        $this->assertEquals([], $result);
    }
}
