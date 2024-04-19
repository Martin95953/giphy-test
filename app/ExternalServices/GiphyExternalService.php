<?php

namespace App\ExternalServices;

use App\Exceptions\GifApiException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class GiphyExternalService
{
    private Client $client;
    private string $api_key;

    public function __construct()
    {
        $this->client = new Client();
        $this->api_key = config('services.giphy.api_key');
    }

    public function search(string $query, int $limit = 10, int $offset = 0)
    {
        try {
            $response = $this->client->request('GET', 'https://api.giphy.com/v1/gifs/search', [
                'query' => [
                    'api_key' => $this->api_key,
                    'q' => $query,
                    'limit' => $limit,
                    'offset' => $offset,
                ]
            ]);
        } catch (GuzzleException $e) {
            $this->generateApiGifException($e);
        }

        return json_decode($response->getBody()->getContents());
    }

    /**
     * @throws GuzzleException
     */
    public function getById(string $id)
    {
        try {
            $response = $this->client->request('GET', 'https://api.giphy.com/v1/gifs/' . $id, [
                'query' => [
                    'api_key' => $this->api_key,
                ]
            ]);
            return json_decode($response->getBody()->getContents());
        } catch (GuzzleException $e) {
            $this->generateApiGifException($e);
        }
    }

    private function generateApiGifException($e) : void
    {
        throw new GifApiException($e->getCode(), $e->getMessage(), $e->getResponse()->getBody()->getContents());
    }
}
