<?php

namespace ZnBundle\Summary\Domain\Repositories\Eloquent;

use ZnBundle\Summary\Domain\Entities\CounterEntity;
use ZnBundle\Summary\Domain\Interfaces\Repositories\CounterRepositoryInterface;
use ZnLib\Db\Base\BaseEloquentCrudRepository;

class CounterRepository extends BaseEloquentCrudRepository implements CounterRepositoryInterface
{

    public function tableName(): string
    {
        return 'summary_counter';
    }

    public function getEntityClass(): string
    {
        return CounterEntity::class;
    }


}

