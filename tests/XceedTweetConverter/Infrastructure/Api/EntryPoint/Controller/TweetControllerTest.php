<?php

namespace App\Tests\XceedTweetConverter\Infrastructure\Api\EntryPoint\Controller;

use App\Tests\XceedTweetConverter\Domain\Mother\TweetMother;
use App\XceedTweetConverter\Application\Find\TweetsFinder;
use App\XceedTweetConverter\Application\Remove\TweetsRemover;
use App\XceedTweetConverter\Application\RetrieveUserTweetsOnUppercase\RetrieveUserTweetsOnUppercase;
use App\XceedTweetConverter\Application\SaveTweetWhenItWasConverted\SaveTweetWhenItWasConverted;
use App\XceedTweetConverter\Infrastructure\Api\EntryPoint\Controller\TweetController;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TweetControllerTest extends TestCase
{
    private RetrieveUserTweetsOnUppercase $retrieveUserTweetsOnUppercaseMock;
    private SaveTweetWhenItWasConverted $saveTweetWhenItWasConvertedMock;
    private TweetsFinder $tweetsFinderMock;
    private TweetsRemover $tweetsRemoverMock;
    private TweetController $controller;

    protected function setUp(): void
    {
        $this->retrieveUserTweetsOnUppercaseMock = $this->createMock(RetrieveUserTweetsOnUppercase::class);
        $this->saveTweetWhenItWasConvertedMock = $this->createMock(SaveTweetWhenItWasConverted::class);
        $this->tweetsFinderMock = $this->createMock(TweetsFinder::class);
        $this->tweetsRemoverMock = $this->createMock(TweetsRemover::class);

        $this->controller = new TweetController(
            $this->retrieveUserTweetsOnUppercaseMock,
            $this->saveTweetWhenItWasConvertedMock,
            $this->tweetsFinderMock,
            $this->tweetsRemoverMock
        );
    }

    public function testGetTweetsSuccess()
    {
        $userName = 'jackDorsey';
        $limit = 5;
        $tweets = [TweetMother::create($userName, 'sample tweet text')];
        $formattedTweets = ['SAMPLE TWEET TEXT'];

        $request = new Request([], ['limit' => $limit]);

        $this->tweetsFinderMock
            ->expects($this->once())
            ->method('findTweetsByUser')
            ->with($userName, $limit)
            ->willReturn($tweets);

        $this->retrieveUserTweetsOnUppercaseMock
            ->expects($this->once())
            ->method('execute')
            ->with($tweets)
            ->willReturn($formattedTweets);

        $this->tweetsRemoverMock
            ->expects($this->once())
            ->method('removeTweetsByUsername')
            ->with($userName);

        $this->saveTweetWhenItWasConvertedMock
            ->expects($this->once())
            ->method('execute')
            ->with($userName, $tweets);


        $response = $this->controller->getTweets($request, $userName);

        $responseData = json_decode($response->getContent(), true);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals($formattedTweets, $responseData);
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }

    public function testGetTweetsException()
    {
        $userName = 'jackDorsey';
        $request = new Request([], ['limit' => 5]);

        $this->tweetsFinderMock
            ->expects($this->once())
            ->method('findTweetsByUser')
            ->will($this->throwException(new \Exception('An error occurred')));

        $response = $this->controller->getTweets($request, $userName);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }
}