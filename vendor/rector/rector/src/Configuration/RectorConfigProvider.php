<?php

declare (strict_types=1);
namespace Rector\Core\Configuration;

use RectorPrefix20220531\Symplify\PackageBuilder\Parameter\ParameterProvider;
/**
 * Rector native configuration provider, to keep deprecated options hidden,
 * but also provide configuration that custom rules can check
 */
final class RectorConfigProvider
{
    /**
     * @readonly
     * @var \Symplify\PackageBuilder\Parameter\ParameterProvider
     */
    private $parameterProvider;
    public function __construct(\RectorPrefix20220531\Symplify\PackageBuilder\Parameter\ParameterProvider $parameterProvider)
    {
        $this->parameterProvider = $parameterProvider;
    }
    public function shouldImportNames() : bool
    {
        return $this->parameterProvider->provideBoolParameter(\Rector\Core\Configuration\Option::AUTO_IMPORT_NAMES);
    }
    public function getSymfonyContainerPhp() : string
    {
        return $this->parameterProvider->provideStringParameter(\Rector\Core\Configuration\Option::SYMFONY_CONTAINER_PHP_PATH_PARAMETER);
    }
    public function getSymfonyContainerXml() : string
    {
        return $this->parameterProvider->provideStringParameter(\Rector\Core\Configuration\Option::SYMFONY_CONTAINER_XML_PATH_PARAMETER);
    }
}
