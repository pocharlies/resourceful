<?php

namespace JDesrosiers\Resourceful\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;

/**
 * Class DeleteResourceController
 * @package JDesrosiers\Resourceful\Controller
 */
class DeleteResourceController extends AbstractResourceController
{
    public function __invoke(Application $app, Request $request, $id)
    {
        if (!$this->service->contains($request->getRequestUri())) {
            throw new NotFoundHttpException("Not Found");
        }

        if ($this->service->delete($request->getRequestURI()) === false) {
            throw new ServiceUnavailableHttpException(null, "Failed to delete resource");
        }

        return Response::create("", Response::HTTP_NO_CONTENT);
    }
}
