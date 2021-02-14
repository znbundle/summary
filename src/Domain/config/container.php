<?php

return [
    'singletons' => [
        'ZnBundle\Summary\Domain\Interfaces\Services\CounterServiceInterface' => 'ZnBundle\Summary\Domain\Services\CounterService',

        'ZnBundle\Summary\Domain\Interfaces\Repositories\CounterRepositoryInterface' => 'ZnBundle\Summary\Domain\Repositories\Eloquent\CounterRepository',
    ],
];
