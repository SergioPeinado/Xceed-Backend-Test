# Xceed Backend Test 

## Description
We want you to implement a REST API that, given a twitter username and a count N, returns the last N tweets in uppercase. We also want to get a cache layer of these tweets in order to avoid hitting Twitter's API (which let's imagine is very expensive) twice for the same username given a T time.

## How to init
To start the project run the following commands:
```
make init
```
If you don't have `make` installed on your system, you can open the `Makefile` and view the commands executed by the `init` command, then run them manually in the terminal.

## Testing
To run the test suite, execute the following command:
```
make run-test
```

To view the application's coverage, execute:
```
make run-test-coverage
```
This will generate a `coverage` folder at the root of the project. Inside the folder, open the `index.html` file with a web browser to view the results.
## Example 

Given these last two tweets from Jack Dorsey:
- "Just setting up my twttr",
- "We need a new mobile OS that’s web-only."

The returned response should be:
```
curl -s http://xceedtestapi.com/tweets/jackDorsey?limit=2
[
    "JUST SETTING UP MY TWTTR",
    "WE ONLY NEED A NEW MOBILE OS THAT'S WEB-ONLY"
]
```

## Constraints 
- Count N provided MUST be equal or less than 10. If not, our API should return an error.

## Code Provided
In order to get you started, we've provided some bootstrap code.
- `TweetConverterController`: Controller wired to Symfony Framework
- `TweetRepository` and `TweetRepositoryInMemory`: We want you to work on domain code. Therefore, we provide an in-memory implementation of the Twitter repository that returns random quotes about Science 🧐. You don't need to implement real communication with Twitter, you can use `TwitterRepositoryInMemory` as a production implementation.
- `Tweet` domain model: Simple class for modeling Tweets returned by `TweetRepository`.

You can run the webserver by running `php -S 127.0.0.1:8000 -t public`. By default it runs on port 8000.

FEEL FREE TO CHANGE ANY OF THE PROVIDED CODE or do it by yourself if you feel more comfortable.

## What will we evaluate?
* **Design**: We know this is a very simple application and can be solved with one line of code but we want to see how you design domain code. Let's pretend this is a super critical application for the company and you're going to maintain it (and make changes requested by the product owner) for years.
* **Testing**: Unitary testing is an important part of our applications. Testing is critical to ensure that changes made by devs does not break other parts of the application and allow us to deploy things faster and safer. 
* **Simplicity**: We like separate code in domain, application and infrastructure layers. If our product owner asks us for the same application but accessed by command line (instead of the http server) it should be super easy!
