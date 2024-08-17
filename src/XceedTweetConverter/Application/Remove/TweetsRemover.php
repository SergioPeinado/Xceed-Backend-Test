<?php

namespace App\XceedTweetConverter\Application\Remove;

use App\XceedTweetConverter\Domain\Helpers\CacheHelper;

class TweetsRemover
{

    public function __construct(private readonly CacheHelper $cacheHelpers)
    {
    }

    public function removeTweetsByUsername(string $username):void
    {
        $this->cacheHelpers->removeTweetsByUsername($username);
    }
}