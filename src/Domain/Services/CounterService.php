<?php

namespace ZnBundle\Summary\Domain\Services;

use ZnBundle\Summary\Domain\Entities\CounterEntity;
use ZnBundle\Summary\Domain\Interfaces\Repositories\CounterRepositoryInterface;
use ZnBundle\Summary\Domain\Interfaces\Services\CounterServiceInterface;
use Packages\User\Domain\Interfaces\Services\SessionServiceInterface;
use ZnBundle\User\Domain\Interfaces\Services\AuthServiceInterface;
use ZnCore\Base\Exceptions\AlreadyExistsException;
use ZnCore\Base\Exceptions\NotFoundException;
use ZnCore\Domain\Base\BaseCrudService;
use ZnCore\Base\Libs\Query\Entities\Where;
use ZnCore\Contract\Domain\Interfaces\Entities\EntityIdInterface;
use ZnCore\Base\Libs\EntityManager\Interfaces\EntityManagerInterface;
use ZnCore\Base\Libs\Query\Entities\Query;

class CounterService extends BaseCrudService implements CounterServiceInterface
{

    private $authService;
    private $sessionService;

    public function __construct(
        EntityManagerInterface $em,
        CounterRepositoryInterface $repository,
        AuthServiceInterface $authService,
        SessionServiceInterface $sessionService
    )
    {
        $this->setEntityManager($em);
        $this->setRepository($repository);
        $this->authService = $authService;
        $this->sessionService = $sessionService;
    }

    public function increment(string $entityName, int $entityId, string $type, bool $isUnique = false): int
    {
        if ($isUnique) {
            try {
                $counterEntity = $this->oneRecord($entityName, $entityId, $type);
                throw new AlreadyExistsException();
            } catch (NotFoundException $e) {
            }
        }

        $counterEntity = new CounterEntity();
        $counterEntity->setEntityName($entityName);
        $counterEntity->setEntityId($entityId);
        $counterEntity->setType($type);

        if (!$this->authService->isGuest()) {
            $userId = $this->authService->getIdentity()->getId();
            $counterEntity->setUserId($userId);
        }

        $sessionEntity = $this->sessionService->currentSession();
        $counterEntity->setSessionId($sessionEntity->getId());
        $this->getRepository()->create($counterEntity);
        return $this->countRecords($entityName, $entityId, $type);
    }

    public function decrement(string $entityName, int $entityId, string $type, bool $isUnique = false): int
    {
        $this->deleteRecord($entityName, $entityId, $type);
        return $this->countRecords($entityName, $entityId, $type);
    }

    private function oneRecord(string $entityName, int $entityId, string $type): EntityIdInterface
    {
        $query = new Query();
        $query->whereNew(new Where('entity_name', $entityName));
        $query->whereNew(new Where('entity_id', $entityId));
        $query->whereNew(new Where('type', $type));
        if (!$this->authService->isGuest()) {
            $userId = $this->authService->getIdentity()->getId();
            $query->whereNew(new Where('user_id', $userId));
        } else {
            $sessionEntity = $this->sessionService->currentSession();
            $query->whereNew(new Where('session_id', $sessionEntity->getId()));
        }
        return $this->getRepository()->one($query);
    }

    private function deleteRecord(string $entityName, int $entityId, string $type): int
    {
        $entity = $this->oneRecord($entityName, $entityId, $type);
        $this->getEntityManager()->remove($entity);
    }

    private function countRecords(string $entityName, int $entityId, string $type): int
    {
        $query = new Query();
        $query->whereNew(new Where('entity_name', $entityName));
        $query->whereNew(new Where('entity_id', $entityId));
        $query->whereNew(new Where('type', $type));
        return $this->getRepository()->count($query);
    }
}
