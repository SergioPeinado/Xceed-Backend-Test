<?php

namespace App\XceedTweetConverter\Infrastructure\Persistence\InMemory;

use App\XceedTweetConverter\Domain\Model\Tweet;
use App\XceedTweetConverter\Domain\Repository\TweetRepository;

final class InMemoryTweetRepository implements TweetRepository
{
    private array $tweets = [
        'jackDorsey' => [
                "The sun is shining and it's a beautiful day!",
                "I just finished a great book and highly recommend it.",
                "Can't wait to travel again and explore new places!",
                "Today's workout was intense but worth it.",
                "Watching my favorite movie for the hundredth time.",
                "Just tried a new restaurant and it was delicious!",
                "I love spending time with my friends and family.",
                "Feeling grateful for all the blessings in my life.",
                "Learning a new skill is always a rewarding experience.",
                "Just finished a challenging project and feeling proud.",
                "Meditation has been a game-changer for my mental health.",
                "Grateful for the small things in life that bring joy.",
                "Spending time in nature always helps me recharge.",
                "There's nothing like a good cup of coffee to start the day.",
                "Feeling motivated to tackle my goals and make progress.",
                "I believe in the power of positive thinking and visualization.",
                "Laughter truly is the best medicine.",
                "I'm so lucky to have such supportive and loving friends.",
                "Just finished a great workout and feeling energized!",
                "Music has the power to lift my mood and inspire me.",
                "I'm grateful for the opportunity to learn and grow.",
                "I believe in treating others with kindness and respect.",
                "Trying new things is scary but also exciting!",
                "I'm so grateful for the wonderful people in my life.",
                "Taking time for self-care is so important for our well-being.",
                "I love exploring new cultures and learning about different traditions.",
                "Gratitude is a powerful practice that can transform our lives.",
                "I'm so grateful for the support and encouragement of my loved ones.",
                "Taking a break and disconnecting from technology is so refreshing.",
                "Trying to stay positive and focused on the good.",
                "I'm grateful for the beauty and wonder of the natural world.",
                "Just finished a great book and feeling inspired!",
                "I believe in the power of setting goals and working towards them.",
                "I'm so grateful for the amazing experiences that life has to offer.",
                "Taking time to reflect and be introspective can be so valuable.",
                "I love trying new recipes and experimenting in the kitchen.",
                "I'm so grateful for the joy and laughter that my pets bring to my life.",
                "Taking care of our mental health is just as important as our physical health.",
                "I believe in the power of community and supporting one another.",
                "I'm grateful for the opportunity to travel and experience new cultures.",
                "Just finished a challenging project and feeling proud of myself.",
                "I'm so lucky to have such amazing and supportive friends in my life.",
                "Gratitude is a mindset that can transform our lives and bring us joy.",
                "I love spending time with my family and creating memories together.",
                "Taking time for self-care is essential for our well-being and happiness.",
                "I believe that every day is a new opportunity to learn and grow.",
                "I'm so grateful for the beauty and wonder of the natural world around us.",
                "Trying to focus on the positive and let go of the negative.",
                "I believe in the power of visualization and manifesting our dreams into reality.",
                "I'm grateful for the amazing experiences that life has to offer us.",
                "Taking time to disconnect and recharge is essential for our well-being.",
            ]
    ];

    public function findTweetsByUser(string $userName, int $limit): array
    {
        if ($limit === 0) {
            return [];
        }

        $userTweets = $this->tweets[$userName] ?? [];
        return array_slice($userTweets, -$limit);
    }

    public function saveTweet(Tweet $tweet): void
    {
        $this->tweets[$tweet->getUserName()][] = $tweet->getText();
    }

    public function removeTweets(string $userName): void
    {}
}
