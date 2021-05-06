<?php

namespace ZnBundle\Summary\Domain\Interfaces\Services;

use ZnBundle\Summary\Domain\Exceptions\AttemptsExhaustedException;
use ZnCore\Domain\Interfaces\Service\CrudServiceInterface;

interface AttemptServiceInterface extends CrudServiceInterface
{

    /**
     * Проверить исчерпаны ли попытки
     * @param int $identityId
     * @param string $action
     * @param int $lifeTime
     * @param int $attemptCount
     * @throws AttemptsExhaustedException
     */
    public function check(int $identityId, string $action, int $lifeTime, int $attemptCount) : void;

    /**
     * Добавить попытку
     * @param int $identityId
     * @param string $action
     * @param null $data
     */
    public function increment(int $identityId, string $action, $data = null) : void;
}

