<?php

namespace App\Tests\XceedTweetConverter\Domain\Exception;


use App\XceedTweetConverter\Domain\Exception\TweetsNotFoundException;
use PHPUnit\Framework\TestCase;

class TweetsNotFoundExceptionTest extends TestCase
{
    public function testExceptionMessage()
    {
        $userName = 'jackDorsey';
        $exception = new TweetsNotFoundException($userName);

        $expectedMessage = sprintf('Tweets not found for: %s', $userName);
        $this->assertEquals($expectedMessage, $exception->getMessage());
    }
}