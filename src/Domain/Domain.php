<?php

namespace ZnBundle\Summary\Domain;

use ZnCore\Domain\Interfaces\DomainInterface;

class Domain implements DomainInterface
{

    public function getName()
    {
        return 'summary';
    }


}

