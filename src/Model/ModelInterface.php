<?php
/**
 * Created by PhpStorm.
 * User: daniel.ibanez
 * Date: 01/03/16
 * Time: 12:48
 */

namespace JDesrosiers\Resourceful\Model;

use Doctrine\Common\Cache\Cache;

interface ModelInterface extends Cache
{
    public function fetchAll();
}