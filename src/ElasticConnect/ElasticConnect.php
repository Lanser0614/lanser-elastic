<?php
namespace Lanser\Elastic\ElasticConnect;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\AuthenticationException;

class ElasticConnect
{
    private Client $client;

    /**
     * @throws AuthenticationException
     */
    public function __construct()
    {
        $this->client = ClientBuilder::create()
            ->setHosts([env('ELASTIC_HOST')])
            ->setBasicAuthentication(env('ELASTIC_USER'), env('ELASTIC_PASSWORD'))
            ->build();
    }

    public function getElasticClient(): Client
    {
        return $this->client;
    }
}