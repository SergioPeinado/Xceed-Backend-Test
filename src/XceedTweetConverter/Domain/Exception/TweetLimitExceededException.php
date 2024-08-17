<?php

namespace App\XceedTweetConverter\Domain\Exception;

class TweetLimitExceededException extends \Exception
{
    public function __construct(int $limit)
    {
        $message = sprintf('Tweet limit cannot be greater than 10. Given limit: %s', $limit);
        parent::__construct($message);
    }
}