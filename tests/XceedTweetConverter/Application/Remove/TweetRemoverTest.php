<?php

namespace App\Tests\XceedTweetConverter\Application\Remove;

use App\XceedTweetConverter\Application\Remove\TweetsRemover;
use App\XceedTweetConverter\Domain\Helpers\CacheHelper;
use PHPUnit\Framework\TestCase;

class TweetRemoverTest extends TestCase
{
    private CacheHelper $cacheHelperMock;
    private TweetsRemover $tweetsRemover;

    protected function setUp(): void
    {
        $this->cacheHelperMock = $this->createMock(CacheHelper::class);

        $this->tweetsRemover = new TweetsRemover($this->cacheHelperMock);
    }

    public function testRemoveTweetsByUsername()
    {
        $username = 'testuser';

        $this->cacheHelperMock->expects($this->once())
            ->method('removeTweetsByUsername')
            ->with($this->equalTo($username));

        $this->tweetsRemover->removeTweetsByUsername($username);
    }
}