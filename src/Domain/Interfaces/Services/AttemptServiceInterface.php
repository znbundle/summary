<?php

namespace ZnBundle\Summary\Domain\Interfaces\Services;

use ZnCore\Domain\Interfaces\Service\CrudServiceInterface;

interface AttemptServiceInterface extends CrudServiceInterface
{

    public function countByIdentityId(int $identityId, string $action, int $lifeTime) : int;
}

