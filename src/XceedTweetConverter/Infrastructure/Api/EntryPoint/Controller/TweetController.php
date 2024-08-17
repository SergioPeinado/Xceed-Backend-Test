<?php

namespace App\XceedTweetConverter\Infrastructure\Api\EntryPoint\Controller;

use App\XceedTweetConverter\Application\Find\TweetsFinder;
use App\XceedTweetConverter\Application\Remove\TweetsRemover;
use App\XceedTweetConverter\Application\RetrieveUserTweetsOnUppercase\RetrieveUserTweetsOnUppercase;
use App\XceedTweetConverter\Application\SaveTweetWhenItWasConverted\SaveTweetWhenItWasConverted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TweetController extends AbstractController
{

    public function __construct(
        private readonly RetrieveUserTweetsOnUppercase $retrieveUserTweetsOnUppercase,
        private readonly SaveTweetWhenItWasConverted $saveTweetWhenItWasConverted,
        private readonly TweetsFinder $tweetsFinder,
        private readonly TweetsRemover $tweetsRemover,
    ) {}

    /**
     * @Route("/tweets/{userName}", methods={"GET"})
     */
    public function getTweets(Request $request, string $userName): JsonResponse
    {
        try {
            $tweets = $this->tweetsFinder->findTweetsByUser($userName, $request->get('limit'));
            $formattedTweets = $this->retrieveUserTweetsOnUppercase->execute($tweets);
            $this->tweetsRemover->removeTweetsByUsername($userName);
            $this->saveTweetWhenItWasConverted->execute($userName, $tweets);
            return new JsonResponse($formattedTweets);
        } catch (\Exception $exception) {
            return new JsonResponse(['error' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
        }

    }
}