<?php
/**
 * Created by PhpStorm.
 * User: daniel.ibanez
 * Date: 26/02/16
 * Time: 10:15
 */

namespace JDesrosiers\Resourceful\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;

class FindResourceController extends AbstractResourceController
{
    public function __invoke(Application $app, Request $request)
    {
        $resource = $this->service->fetchAll($request->getRequestUri());
        if ($resource === false) {
            throw new ServiceUnavailableHttpException(null, "Failed to retrieve resource");
        }
        $response = JsonResponse::create($resource);
        $response->headers->set("Content-Type", $this->contentType);

        return $response;
    }

    public function test()
    {
        return 'test';
    }

    private function validate(Application $app, $data)
    {
        $schema = $app["json-schema.schema-store"]->get($this->schema);
        $validation = $app["json-schema.validator"]->validate($data, $schema);
        if (!$validation->valid) {
            throw new BadRequestHttpException(json_encode($validation->errors));
        }
    }
}