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
            ->setHosts(config('elastic.hosts'))
            ->setBasicAuthentication(config('elastic.username'), config('elastic.password'))
            ->build();
    }

    public function getElasticClient(): Client
    {
        return $this->client;
    }
}