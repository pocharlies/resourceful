<?php
/**
 * Created by PhpStorm.
 * User: daniel.ibanez
 * Date: 29/02/16
 * Time: 15:07
 */

namespace JDesrosiers\Resourceful\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;

class PatchResourceController
{
    /**
     * @param Application $app
     * @param Request $request
     * @param $id
     * @return mixed
     * @throws ServiceUnavailableHttpException
     */
    function __invoke(Application $app, Request $request, $id)
    {
        $requestJson = $request->getContent() ?: "{}";
        $data = json_decode($requestJson);

        $this->validate($app, $id, $data);

        $isCreated = !$this->service->contains($request->getRequestUri());
        if ($this->service->save($request->getRequestUri(), $data) === false) {
            throw new ServiceUnavailableHttpException(null, "Failed to save resource");
        }

        return JsonResponse::create($data, $isCreated ? Response::HTTP_CREATED : Response::HTTP_OK);
    }
}