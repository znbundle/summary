<?php

namespace ZnBundle\Summary\Domain\Interfaces\Repositories;

use ZnCore\Domain\Interfaces\Repository\CrudRepositoryInterface;

interface AttemptRepositoryInterface extends CrudRepositoryInterface
{

    /**
     * Получить количество попыток
     * @param int $identityId
     * @param string $action
     * @param int $lifeTime
     * @return int
     */
    public function countByIdentityId(int $identityId, string $action, int $lifeTime): int;
}

