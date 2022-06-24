<?php

namespace ZnBundle\Summary;

use ZnCore\Base\Bundle\Base\BaseBundle;

class Bundle extends BaseBundle
{

    public function i18next(): array
    {
        return [
            'summary' => 'vendor/znbundle/summary/src/Domain/i18next/__lng__/__ns__.json',
        ];
    }

    public function migration(): array
    {
        return [
            '/vendor/znbundle/summary/src/Domain/Migrations',
        ];
    }

    public function container(): array
    {
        return [
            __DIR__ . '/Domain/config/container.php',
        ];
    }
}
