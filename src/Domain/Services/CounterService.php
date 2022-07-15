<?php

namespace ZnBundle\Summary\Domain\Services;

use ZnBundle\Summary\Domain\Entities\CounterEntity;
use ZnBundle\Summary\Domain\Interfaces\Repositories\CounterRepositoryInterface;
use ZnBundle\Summary\Domain\Interfaces\Services\CounterServiceInterface;
use Packages\User\Domain\Interfaces\Services\SessionServiceInterface;
use ZnUser\Authentication\Domain\Interfaces\Services\AuthServiceInterface;
use ZnDomain\Entity\Exceptions\AlreadyExistsException;
use ZnCore\Contract\Common\Exceptions\NotFoundException;
use ZnDomain\Service\Base\BaseCrudService;
use ZnDomain\Query\Entities\Where;
use ZnDomain\Entity\Interfaces\EntityIdInterface;
use ZnDomain\EntityManager\Interfaces\EntityManagerInterface;
use ZnDomain\Query\Entities\Query;

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
        return $this->getRepository()->findOne($query);
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
