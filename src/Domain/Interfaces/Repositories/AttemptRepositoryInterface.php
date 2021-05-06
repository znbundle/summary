<?php

namespace ZnBundle\Summary\Domain\Interfaces\Repositories;

use ZnCore\Domain\Interfaces\Repository\CrudRepositoryInterface;

interface AttemptRepositoryInterface extends CrudRepositoryInterface
{

    public function countByIdentityId(int $identityId, string $action, int $lifeTime): int;
}

