<?php
/**
 * Created by PhpStorm.
 * User: daniel.ibanez
 * Date: 26/02/16
 * Time: 14:06
 */

namespace JDesrosiers\Resourceful\Controller;


use Doctrine\Common\Cache\Cache;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class AbstractResourceController
{
    protected $service;
    protected $schema;
    protected $contentType;

    public function __construct(Cache $service, $schema, $contentType = "application/json")
    {
        $this->service = $service;
        $this->schema = $schema;
        $this->contentType = $contentType;
    }
}