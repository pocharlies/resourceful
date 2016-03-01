<?php

namespace JDesrosiers\Resourceful\Controller;

use Doctrine\Common\Cache\Cache;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;

class GetResourceController extends AbstractResourceController
{

    public function __invoke(Request $request)
    {
        if (!$this->service->contains($request->getRequestUri())) {
            throw new NotFoundHttpException("Not Found");
        }

        $resource = $this->service->fetch($request->getRequestUri());
        if ($resource === false) {
            throw new ServiceUnavailableHttpException(null, "Failed to retrieve resource");
        }

        $response = JsonResponse::create($resource);
        $response->headers->set("Content-Type", $this->contentType);

        return $response;
    }
}
