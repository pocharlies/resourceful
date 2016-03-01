<?php
/**
 * Created by PhpStorm.
 * User: daniel.ibanez
 * Date: 26/02/16
 * Time: 10:19
 */

namespace JDesrosiers\Resourceful\Controller;

use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Cache\Cache;
use Silex\Application;

interface ResourceControllerInterface
{
    public function __contruct(Cache $service, $chema);

    public function __invoke(Application $app, Request $request, $id);
}