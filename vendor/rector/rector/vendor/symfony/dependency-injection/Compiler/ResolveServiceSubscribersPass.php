<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RectorPrefix20220531\Symfony\Component\DependencyInjection\Compiler;

use RectorPrefix20220531\Psr\Container\ContainerInterface;
use RectorPrefix20220531\Symfony\Component\DependencyInjection\Definition;
use RectorPrefix20220531\Symfony\Component\DependencyInjection\Reference;
use RectorPrefix20220531\Symfony\Contracts\Service\ServiceProviderInterface;
/**
 * Compiler pass to inject their service locator to service subscribers.
 *
 * @author Nicolas Grekas <p@tchwork.com>
 */
class ResolveServiceSubscribersPass extends \RectorPrefix20220531\Symfony\Component\DependencyInjection\Compiler\AbstractRecursivePass
{
    /**
     * @var string|null
     */
    private $serviceLocator;
    /**
     * @param mixed $value
     * @return mixed
     */
    protected function processValue($value, bool $isRoot = \false)
    {
        if ($value instanceof \RectorPrefix20220531\Symfony\Component\DependencyInjection\Reference && $this->serviceLocator && \in_array((string) $value, [\RectorPrefix20220531\Psr\Container\ContainerInterface::class, \RectorPrefix20220531\Symfony\Contracts\Service\ServiceProviderInterface::class], \true)) {
            return new \RectorPrefix20220531\Symfony\Component\DependencyInjection\Reference($this->serviceLocator);
        }
        if (!$value instanceof \RectorPrefix20220531\Symfony\Component\DependencyInjection\Definition) {
            return parent::processValue($value, $isRoot);
        }
        $serviceLocator = $this->serviceLocator;
        $this->serviceLocator = null;
        if ($value->hasTag('container.service_subscriber.locator')) {
            $this->serviceLocator = $value->getTag('container.service_subscriber.locator')[0]['id'];
            $value->clearTag('container.service_subscriber.locator');
        }
        try {
            return parent::processValue($value);
        } finally {
            $this->serviceLocator = $serviceLocator;
        }
    }
}
