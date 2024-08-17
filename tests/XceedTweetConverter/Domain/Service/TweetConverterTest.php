<?php

namespace App\Tests\XceedTweetConverter\Domain\Service;

use App\Tests\XceedTweetConverter\Domain\Mother\TweetMother;
use App\XceedTweetConverter\Domain\Service\TweetConverter;
use PHPUnit\Framework\TestCase;

class TweetConverterTest extends TestCase
{
    public function testConvertToUppercase()
    {
        $userId = 'jackDorsey';
        $tweetText = 'sample tweet text';
        $uppercaseText = 'SAMPLE TWEET TEXT';

        $tweetMock = TweetMother::create($userId, $tweetText);

        $tweetConverter = new TweetConverter();
        $convertedTweet = $tweetConverter->convertToUppercase($tweetMock);

        $this->assertEquals($uppercaseText, $convertedTweet->getText());
    }
}