<?php

namespace App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Bundle\DebugBundle\DebugBundle; // Assurez-vous que DebugBundle est utilisé ici
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    protected function configureBundles(): iterable
    {
        $bundles = [
            Symfony\Bundle\FrameworkBundle\FrameworkBundle::class => ['all' => true],
        ];

        // Inclure DebugBundle uniquement en dev/test
        if ($this->getEnvironment() === 'dev' || $this->getEnvironment() === 'test') {
            $bundles[DebugBundle::class] = ['dev' => true, 'test' => true];
        }

        foreach ($bundles as $class => $envs) {
            if (isset($envs['all']) || isset($envs[$this->getEnvironment()])) {
                yield new $class();
            }
        }
    }
}
