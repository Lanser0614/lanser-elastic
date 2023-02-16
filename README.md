# lanser-elastic

# composer require lanser/elastic:dev-main
Add in your env
# ELASTIC_HOST=
# ELASTIC_USER=
# ELASTIC_PASSWORD=

And add LanserElasticServiceProvider into you config\app.php to section providers

after that you can use Elastic client like
# $client = app(ElasticConnect::class);
