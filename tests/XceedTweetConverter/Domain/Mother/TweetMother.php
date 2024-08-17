<?php

namespace App\Tests\XceedTweetConverter\Domain\Mother;

use App\XceedTweetConverter\Domain\Model\Tweet;

class TweetMother
{
    public static function create(
        string $userName,
        string $text
    ): Tweet
    {
        return new Tweet($userName, $text);
    }
}