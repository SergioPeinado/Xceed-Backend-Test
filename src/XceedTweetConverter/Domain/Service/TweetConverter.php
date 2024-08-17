<?php

namespace App\XceedTweetConverter\Domain\Service;

use App\XceedTweetConverter\Domain\Model\Tweet;

class TweetConverter
{
    public function convertToUppercase(Tweet $tweet): Tweet
    {
        $tweet->toUppercase();
        return $tweet;
    }
}