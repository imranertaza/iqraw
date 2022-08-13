<?php

declare (strict_types=1);
namespace Rector\Core\Application\FileSystem;

use Rector\Core\Contract\Console\OutputStyleInterface;
use Rector\Core\PhpParser\Printer\NodesWithFileDestinationPrinter;
use Rector\Core\ValueObject\Configuration;
use RectorPrefix20220531\Symplify\SmartFileSystem\SmartFileSystem;
/**
 * Adds and removes scheduled file
 */
final class RemovedAndAddedFilesProcessor
{
    /**
     * @readonly
     * @var \Symplify\SmartFileSystem\SmartFileSystem
     */
    private $smartFileSystem;
    /**
     * @readonly
     * @var \Rector\Core\PhpParser\Printer\NodesWithFileDestinationPrinter
     */
    private $nodesWithFileDestinationPrinter;
    /**
     * @readonly
     * @var \Rector\Core\Application\FileSystem\RemovedAndAddedFilesCollector
     */
    private $removedAndAddedFilesCollector;
    /**
     * @readonly
     * @var \Rector\Core\Contract\Console\OutputStyleInterface
     */
    private $rectorOutputStyle;
    public function __construct(\RectorPrefix20220531\Symplify\SmartFileSystem\SmartFileSystem $smartFileSystem, \Rector\Core\PhpParser\Printer\NodesWithFileDestinationPrinter $nodesWithFileDestinationPrinter, \Rector\Core\Application\FileSystem\RemovedAndAddedFilesCollector $removedAndAddedFilesCollector, \Rector\Core\Contract\Console\OutputStyleInterface $rectorOutputStyle)
    {
        $this->smartFileSystem = $smartFileSystem;
        $this->nodesWithFileDestinationPrinter = $nodesWithFileDestinationPrinter;
        $this->removedAndAddedFilesCollector = $removedAndAddedFilesCollector;
        $this->rectorOutputStyle = $rectorOutputStyle;
    }
    public function run(\Rector\Core\ValueObject\Configuration $configuration) : void
    {
        $this->processAddedFilesWithContent($configuration);
        $this->processAddedFilesWithNodes($configuration);
        $this->processMovedFilesWithNodes($configuration);
        $this->processDeletedFiles($configuration);
    }
    private function processDeletedFiles(\Rector\Core\ValueObject\Configuration $configuration) : void
    {
        foreach ($this->removedAndAddedFilesCollector->getRemovedFiles() as $removedFile) {
            $relativePath = $removedFile->getRelativeFilePathFromDirectory(\getcwd());
            if ($configuration->isDryRun()) {
                $message = \sprintf('File "%s" will be removed', $relativePath);
                $this->rectorOutputStyle->warning($message);
            } else {
                $message = \sprintf('File "%s" was removed', $relativePath);
                $this->rectorOutputStyle->warning($message);
                $this->smartFileSystem->remove($removedFile->getPathname());
            }
        }
    }
    private function processAddedFilesWithContent(\Rector\Core\ValueObject\Configuration $configuration) : void
    {
        foreach ($this->removedAndAddedFilesCollector->getAddedFilesWithContent() as $addedFileWithContent) {
            if ($configuration->isDryRun()) {
                $message = \sprintf('File "%s" will be added', $addedFileWithContent->getFilePath());
                $this->rectorOutputStyle->note($message);
            } else {
                $this->smartFileSystem->dumpFile($addedFileWithContent->getFilePath(), $addedFileWithContent->getFileContent());
                $message = \sprintf('File "%s" was added', $addedFileWithContent->getFilePath());
                $this->rectorOutputStyle->note($message);
            }
        }
    }
    private function processAddedFilesWithNodes(\Rector\Core\ValueObject\Configuration $configuration) : void
    {
        foreach ($this->removedAndAddedFilesCollector->getAddedFilesWithNodes() as $addedFileWithNode) {
            $fileContent = $this->nodesWithFileDestinationPrinter->printNodesWithFileDestination($addedFileWithNode);
            if ($configuration->isDryRun()) {
                $message = \sprintf('File "%s" will be added', $addedFileWithNode->getFilePath());
                $this->rectorOutputStyle->note($message);
            } else {
                $this->smartFileSystem->dumpFile($addedFileWithNode->getFilePath(), $fileContent);
                $message = \sprintf('File "%s" was added', $addedFileWithNode->getFilePath());
                $this->rectorOutputStyle->note($message);
            }
        }
    }
    private function processMovedFilesWithNodes(\Rector\Core\ValueObject\Configuration $configuration) : void
    {
        foreach ($this->removedAndAddedFilesCollector->getMovedFiles() as $movedFile) {
            $fileContent = $this->nodesWithFileDestinationPrinter->printNodesWithFileDestination($movedFile);
            if ($configuration->isDryRun()) {
                $message = \sprintf('File "%s" will be moved to "%s"', $movedFile->getFilePath(), $movedFile->getNewFilePath());
                $this->rectorOutputStyle->note($message);
            } else {
                $this->smartFileSystem->dumpFile($movedFile->getNewFilePath(), $fileContent);
                $this->smartFileSystem->remove($movedFile->getFilePath());
                $message = \sprintf('File "%s" was moved to "%s"', $movedFile->getFilePath(), $movedFile->getNewFilePath());
                $this->rectorOutputStyle->note($message);
            }
        }
    }
}
