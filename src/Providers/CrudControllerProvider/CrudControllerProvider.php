<?php

namespace JDesrosiers\Resourceful\Providers\CrudControllerProvider;

use Doctrine\Common\Cache\Cache;
use JDesrosiers\Resourceful\Controller\CreateResourceController;
use JDesrosiers\Resourceful\Controller\DeleteResourceController;
use JDesrosiers\Resourceful\Controller\FindResourceController;
use JDesrosiers\Resourceful\Controller\GetResourceController;
use JDesrosiers\Resourceful\Controller\PatchResourceController;
use JDesrosiers\Resourceful\Controller\PutResourceController;
use JDesrosiers\Resourceful\Providers\ResourcefulServiceProvider\AddSchema;
use Silex\Application;
use Silex\ControllerProviderInterface;
use Twig_Loader_Filesystem;

class CrudControllerProvider implements ControllerProviderInterface
{
    private $type;
    private $service;

    public function __construct($type, Cache $service)
    {
        $this->type = strtolower($type);
        $this->service = $service;
    }

    public function connect(Application $app)
    {
        $schema = $app["url_generator"]->generate("schema", array("type" => $this->type));
        $resource = $app["resources_factory"]($schema);

        $app["twig.loader"]->addLoader(new Twig_Loader_Filesystem(__DIR__ . "/templates"));
        $replacements = array("type" => $this->type, "title" => ucfirst($this->type));

        // Create Schema swagger
        $app->before(new AddSchema($schema, "crud", $replacements));

        $resource->get("/{id}", new GetResourceController($this->service, $schema, $app['resources.contentType']))->bind($schema);
        $resource->put("/{id}", new PutResourceController($this->service, $schema, $app['resources.contentType']));
        $resource->delete("/{id}", new DeleteResourceController($this->service, $schema, $app['resources.contentType']));
        $resource->post("/", new CreateResourceController($this->service, $schema, $app['resources.contentType']));
        $resource->get("/", new FindResourceController($this->service, $schema, $app['resources.contentType']));
        $resource->patch("/", new PatchResourceController($this->service, $schema, $app['resources.contentType']));

        return $resource;
    }
}
