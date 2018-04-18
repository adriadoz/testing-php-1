<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    private $lastResponse;
    private $lastStatusCode;
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /**
     * @Given /^I do a "([^"]*)" request to "([^"]*)"$/
     */
    public function iDoARequestTo($method, $uri)
    {
        $client = new Client(['base_uri' => 'https://pokeapi.co/api/v2']);

        try {
            $request = $client->request($method, $uri);

            $this->lastResponse   = $request->getBody()->getContents();
            $this->lastStatusCode = $request->getStatusCode();
        } catch (ClientException $exception) {
            $this->lastResponse   = $exception->getResponse()->getBody();
            $this->lastStatusCode = $exception->getResponse()->getStatusCode();
        }
    }

    /**
     * @Then /^the response code should be "([^"]*)"$/
     */
    public function theResponseCodeShouldBe($statusCode)
    {
        if ($this->lastStatusCode != $statusCode) {
            throw new Exception('Status code is not the expected');
        }
    }

    /**
     * @Given /^the response should be:$/
     */
    public function theResponseShouldBe(PyStringNode $string)
    {
        $a = json_decode($string->getRaw());
        $b = json_decode($this->lastResponse);
        if (json_encode($a) !== json_encode($b)) {
            throw new Exception('Response is not the same');
        }
    }
}
