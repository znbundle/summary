<?php

namespace ZnBundle\Summary\Domain\Services;

use ZnBundle\Summary\Domain\Interfaces\Services\AttemptServiceInterface;
use ZnCore\Domain\Interfaces\Libs\EntityManagerInterface;
use ZnCore\Domain\Base\BaseCrudService;
use ZnBundle\Summary\Domain\Entities\AttemptEntity;

class AttemptService extends BaseCrudService implements AttemptServiceInterface
{

    public function __construct(EntityManagerInterface $em)
    {
        $this->setEntityManager($em);
    }

    public function getEntityClass() : string
    {
        return AttemptEntity::class;
    }

    public function countByIdentityId(int $identityId, string $action, int $lifeTime) : int
    {
        return $this->getRepository()->countByIdentityId($identityId, $action, $lifeTime);
    }

    public function add(int $identityId, string $action, $data = null) {
        $attemptEntity = new AttemptEntity();
        $attemptEntity->setIdentityId($identityId);
        $attemptEntity->setAction($action);
        $attemptEntity->setData($data);
        $this->getEntityManager()->persist($attemptEntity);
    }
}
