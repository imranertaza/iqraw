<?php

declare (strict_types=1);
namespace Rector\Core\Autoloading;

use Rector\Core\Configuration\Option;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\Core\FileSystem\FilesFinder;
use RectorPrefix20220531\Symplify\PackageBuilder\Parameter\ParameterProvider;
use Throwable;
use RectorPrefix20220531\Webmozart\Assert\Assert;
final class BootstrapFilesIncluder
{
    /**
     * @readonly
     * @var \Symplify\PackageBuilder\Parameter\ParameterProvider
     */
    private $parameterProvider;
    /**
     * @readonly
     * @var \Rector\Core\FileSystem\FilesFinder
     */
    private $filesFinder;
    public function __construct(\RectorPrefix20220531\Symplify\PackageBuilder\Parameter\ParameterProvider $parameterProvider, \Rector\Core\FileSystem\FilesFinder $filesFinder)
    {
        $this->parameterProvider = $parameterProvider;
        $this->filesFinder = $filesFinder;
    }
    /**
     * Inspired by
     * @see https://github.com/phpstan/phpstan-src/commit/aad1bf888ab7b5808898ee5fe2228bb8bb4e4cf1
     */
    public function includeBootstrapFiles() : void
    {
        $bootstrapFiles = $this->parameterProvider->provideArrayParameter(\Rector\Core\Configuration\Option::BOOTSTRAP_FILES);
        \RectorPrefix20220531\Webmozart\Assert\Assert::allString($bootstrapFiles);
        /** @var string[] $bootstrapFiles */
        foreach ($bootstrapFiles as $bootstrapFile) {
            if (!\is_file($bootstrapFile)) {
                throw new \Rector\Core\Exception\ShouldNotHappenException(\sprintf('Bootstrap file "%s" does not exist.', $bootstrapFile));
            }
            try {
                require_once $bootstrapFile;
            } catch (\Throwable $throwable) {
                $errorMessage = \sprintf('"%s" thrown in "%s" on line %d while loading bootstrap file %s: %s', \get_class($throwable), $throwable->getFile(), $throwable->getLine(), $bootstrapFile, $throwable->getMessage());
                throw new \Rector\Core\Exception\ShouldNotHappenException($errorMessage, $throwable->getCode(), $throwable);
            }
        }
        $stubsRectorDirectory = \realpath(__DIR__ . '/../../stubs-rector');
        if ($stubsRectorDirectory === \false) {
            return;
        }
        $stubs = $this->filesFinder->findInDirectoriesAndFiles([$stubsRectorDirectory], ['php']);
        foreach ($stubs as $stub) {
            require_once $stub->getRealPath();
        }
    }
}
