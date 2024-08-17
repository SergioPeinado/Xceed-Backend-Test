<?php

namespace App\Tests\XceedTweetConverter\Domain\Exception;

use App\XceedTweetConverter\Domain\Exception\TweetLimitExceededException;
use PHPUnit\Framework\TestCase;

class TweetLimitExceededExceptionTest extends TestCase
{
    public function testExceptionMessage()
    {
        $limit = 11;
        $exception = new TweetLimitExceededException($limit);

        $expectedMessage = sprintf('Tweet limit cannot be greater than 10. Given limit: %s', $limit);
        $this->assertEquals($expectedMessage, $exception->getMessage());
    }
}