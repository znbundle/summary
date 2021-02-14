<?php

namespace ZnBundle\Summary\Domain\Interfaces\Services;

use ZnCore\Base\Exceptions\AlreadyExistsException;
use ZnCore\Base\Exceptions\NotFoundException;
use ZnCore\Domain\Interfaces\Service\CrudServiceInterface;

interface CounterServiceInterface extends CrudServiceInterface
{

    /**
     * @param string $entityName
     * @param int $entityId
     * @param string $type
     * @param bool $isUnique
     * @return int
     * @throws AlreadyExistsException
     */
    public function increment(string $entityName, int $entityId, string $type, bool $isUnique = false): int;

    /**
     * @param string $entityName
     * @param int $entityId
     * @param string $type
     * @param bool $isUnique
     * @return int
     * @throws NotFoundException
     */
    public function decrement(string $entityName, int $entityId, string $type, bool $isUnique = false): int;
}
