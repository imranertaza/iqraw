<?php

declare (strict_types=1);
namespace RectorPrefix20220531;

use Rector\Config\RectorConfig;
use Rector\Symfony\Rector\Property\JMSInjectPropertyToConstructorInjectionRector;
return static function (\Rector\Config\RectorConfig $rectorConfig) : void {
    $rectorConfig->rule(\Rector\Symfony\Rector\Property\JMSInjectPropertyToConstructorInjectionRector::class);
};
