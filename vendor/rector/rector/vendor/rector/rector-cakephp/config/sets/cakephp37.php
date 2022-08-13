<?php

declare (strict_types=1);
namespace RectorPrefix20220531;

use Rector\CakePHP\Rector\MethodCall\ModalToGetSetRector;
use Rector\CakePHP\Rector\Property\ChangeSnakedFixtureNameToPascalRector;
use Rector\CakePHP\ValueObject\ModalToGetSet;
use Rector\Config\RectorConfig;
use Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use Rector\Renaming\ValueObject\MethodCallRename;
use Rector\Transform\Rector\Assign\PropertyFetchToMethodCallRector;
use Rector\Transform\Rector\MethodCall\MethodCallToAnotherMethodCallWithArgumentsRector;
use Rector\Transform\ValueObject\MethodCallToAnotherMethodCallWithArguments;
use Rector\Transform\ValueObject\PropertyFetchToMethodCall;
# source: https://book.cakephp.org/3.0/en/appendices/3-7-migration-guide.html
return static function (\Rector\Config\RectorConfig $rectorConfig) : void {
    $rectorConfig->ruleWithConfiguration(\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class, [new \Rector\Renaming\ValueObject\MethodCallRename('Cake\\Form\\Form', 'errors', 'getErrors'), new \Rector\Renaming\ValueObject\MethodCallRename('Cake\\Validation\\Validation', 'cc', 'creditCard'), new \Rector\Renaming\ValueObject\MethodCallRename('Cake\\Filesystem\\Folder', 'normalizePath', 'correctSlashFor'), new \Rector\Renaming\ValueObject\MethodCallRename('Cake\\Http\\Client\\Response', 'body', 'getStringBody'), new \Rector\Renaming\ValueObject\MethodCallRename('Cake\\Core\\Plugin', 'unload', 'clear')]);
    $rectorConfig->ruleWithConfiguration(\Rector\Transform\Rector\Assign\PropertyFetchToMethodCallRector::class, [new \Rector\Transform\ValueObject\PropertyFetchToMethodCall('Cake\\Http\\Client\\Response', 'body', 'getStringBody'), new \Rector\Transform\ValueObject\PropertyFetchToMethodCall('Cake\\Http\\Client\\Response', 'json', 'getJson'), new \Rector\Transform\ValueObject\PropertyFetchToMethodCall('Cake\\Http\\Client\\Response', 'xml', 'getXml'), new \Rector\Transform\ValueObject\PropertyFetchToMethodCall('Cake\\Http\\Client\\Response', 'cookies', 'getCookies'), new \Rector\Transform\ValueObject\PropertyFetchToMethodCall('Cake\\Http\\Client\\Response', 'code', 'getStatusCode'), new \Rector\Transform\ValueObject\PropertyFetchToMethodCall('Cake\\View\\View', 'request', 'getRequest', 'setRequest'), new \Rector\Transform\ValueObject\PropertyFetchToMethodCall('Cake\\View\\View', 'response', 'getResponse', 'setResponse'), new \Rector\Transform\ValueObject\PropertyFetchToMethodCall('Cake\\View\\View', 'templatePath', 'getTemplatePath', 'setTemplatePath'), new \Rector\Transform\ValueObject\PropertyFetchToMethodCall('Cake\\View\\View', 'template', 'getTemplate', 'setTemplate'), new \Rector\Transform\ValueObject\PropertyFetchToMethodCall('Cake\\View\\View', 'layout', 'getLayout', 'setLayout'), new \Rector\Transform\ValueObject\PropertyFetchToMethodCall('Cake\\View\\View', 'layoutPath', 'getLayoutPath', 'setLayoutPath'), new \Rector\Transform\ValueObject\PropertyFetchToMethodCall('Cake\\View\\View', 'autoLayout', 'isAutoLayoutEnabled', 'enableAutoLayout'), new \Rector\Transform\ValueObject\PropertyFetchToMethodCall('Cake\\View\\View', 'theme', 'getTheme', 'setTheme'), new \Rector\Transform\ValueObject\PropertyFetchToMethodCall('Cake\\View\\View', 'subDir', 'getSubDir', 'setSubDir'), new \Rector\Transform\ValueObject\PropertyFetchToMethodCall('Cake\\View\\View', 'plugin', 'getPlugin', 'setPlugin'), new \Rector\Transform\ValueObject\PropertyFetchToMethodCall('Cake\\View\\View', 'name', 'getName', 'setName'), new \Rector\Transform\ValueObject\PropertyFetchToMethodCall('Cake\\View\\View', 'elementCache', 'getElementCache', 'setElementCache'), new \Rector\Transform\ValueObject\PropertyFetchToMethodCall('Cake\\View\\View', 'helpers', 'helpers')]);
    $rectorConfig->ruleWithConfiguration(\Rector\Transform\Rector\MethodCall\MethodCallToAnotherMethodCallWithArgumentsRector::class, [new \Rector\Transform\ValueObject\MethodCallToAnotherMethodCallWithArguments('Cake\\Database\\Query', 'join', 'clause', ['join']), new \Rector\Transform\ValueObject\MethodCallToAnotherMethodCallWithArguments('Cake\\Database\\Query', 'from', 'clause', ['from'])]);
    $rectorConfig->ruleWithConfiguration(\Rector\CakePHP\Rector\MethodCall\ModalToGetSetRector::class, [new \Rector\CakePHP\ValueObject\ModalToGetSet('Cake\\Database\\Connection', 'logQueries', 'isQueryLoggingEnabled', 'enableQueryLogging'), new \Rector\CakePHP\ValueObject\ModalToGetSet('Cake\\ORM\\Association', 'className', 'getClassName', 'setClassName')]);
    $rectorConfig->rule(\Rector\CakePHP\Rector\Property\ChangeSnakedFixtureNameToPascalRector::class);
};
