<?php

namespace JDesrosiers\Resourceful\Providers\SchemaControllerProvider;

use JDesrosiers\Resourceful\Controller\GetResourceController;
use Silex\Application;
use Silex\ControllerProviderInterface;

class SchemaControllerProvider implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $resource = $app["resources_factory"]("http://json-schema.org/hyper-schema");

        $resource->get("/{type}", new GetResourceController($app["resourceful.schemaStore"], "application/schema+json"))
            ->assert("type", ".+")
            ->bind("schema");

        return $resource;
    }
}
