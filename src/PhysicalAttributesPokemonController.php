<?php

declare(strict_types = 1);

namespace PokemonApi\Module;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class PhysicalAttributesPokemonController
{
    private $url;
    private $id;
    private $lastResponse;
    private $lastStatusCode;
    private $processedData;

    public function __construct($url)
    {
        $this->url = $url;
    }
    public function __invoke(): array
    {
        $pos = strrpos($this->url, '/');
        $this->id = $pos === false ? $this->url : substr($this->url, $pos + 1);

        if (isset($this->id) && $this->id !=="pokemon") {
            $method = "GET";
            $uri = "pokemon/".$this->id;
            $client = new Client(['base_uri' => 'http://pokeapi.salestock.net/api/v2/']);
            try {
                $request = $client->request($method, $uri);
                $this->lastResponse   = $request->getBody()->getContents();
                $this->lastStatusCode = $request->getStatusCode();
            } catch (ClientException $exception) {
                $this->lastResponse   = $exception->getResponse()->getBody();
                $this->lastStatusCode = $exception->getResponse()->getStatusCode();
            }
        }

        return array("code" => $this->lastStatusCode, "data" => $this->lastResponse,);
    }

    public function extractPhysicalAttributes($rawData){
        var_dump($rawData);
    }
}