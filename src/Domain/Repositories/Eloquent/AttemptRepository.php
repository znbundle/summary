<?php

namespace ZnBundle\Summary\Domain\Repositories\Eloquent;

use ZnBundle\Summary\Domain\Entities\AttemptEntity;
use ZnBundle\Summary\Domain\Interfaces\Repositories\AttemptRepositoryInterface;
use ZnCore\Domain\Query\Entities\Where;
use ZnCore\Domain\Query\Enums\OperatorEnum;
use ZnCore\Domain\Query\Entities\Query;
use ZnDatabase\Eloquent\Domain\Base\BaseEloquentCrudRepository;

class AttemptRepository extends BaseEloquentCrudRepository implements AttemptRepositoryInterface
{

    public function tableName(): string
    {
        return 'summary_attempt';
    }

    public function getEntityClass(): string
    {
        return AttemptEntity::class;
    }

    public function countByIdentityId(int $identityId, string $action, int $lifeTime): int
    {
        $date = new \DateTime();
        $date->modify("-{$lifeTime} seconds");
        $query = new Query;
        $query->where('identity_id', $identityId);
        $query->whereNew(new Where('created_at', $date, OperatorEnum::GREATER));
        return $this->count($query);
    }
}
