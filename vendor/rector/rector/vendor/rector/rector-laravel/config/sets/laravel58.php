<?php

declare (strict_types=1);
namespace RectorPrefix20220531;

use PHPStan\Type\BooleanType;
use Rector\Config\RectorConfig;
use Rector\Laravel\Rector\Class_\PropertyDeferToDeferrableProviderToRector;
use Rector\Laravel\Rector\StaticCall\MinutesToSecondsInCacheRector;
use Rector\Renaming\Rector\PropertyFetch\RenamePropertyRector;
use Rector\Renaming\ValueObject\RenameProperty;
use Rector\TypeDeclaration\Rector\ClassMethod\AddReturnTypeDeclarationRector;
use Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration;
# https://laravel-news.com/laravel-5-8-deprecates-string-and-array-helpers
# https://github.com/laravel/framework/pull/26898
# see: https://laravel.com/docs/5.8/upgrade
return static function (\Rector\Config\RectorConfig $rectorConfig) : void {
    $rectorConfig->import(__DIR__ . '/laravel-array-str-functions-to-static-call.php');
    $rectorConfig->rule(\Rector\Laravel\Rector\StaticCall\MinutesToSecondsInCacheRector::class);
    $rectorConfig->ruleWithConfiguration(\Rector\TypeDeclaration\Rector\ClassMethod\AddReturnTypeDeclarationRector::class, [new \Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration('Illuminate\\Contracts\\Cache\\Repository', 'put', new \PHPStan\Type\BooleanType()), new \Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration('Illuminate\\Contracts\\Cache\\Repository', 'forever', new \PHPStan\Type\BooleanType()), new \Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration('Illuminate\\Contracts\\Cache\\Store', 'put', new \PHPStan\Type\BooleanType()), new \Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration('Illuminate\\Contracts\\Cache\\Store', 'putMany', new \PHPStan\Type\BooleanType()), new \Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration('Illuminate\\Contracts\\Cache\\Store', 'forever', new \PHPStan\Type\BooleanType())]);
    $rectorConfig->ruleWithConfiguration(\Rector\Renaming\Rector\PropertyFetch\RenamePropertyRector::class, [new \Rector\Renaming\ValueObject\RenameProperty('Illuminate\\Routing\\UrlGenerator', 'cachedSchema', 'cachedScheme')]);
    $rectorConfig->rule(\Rector\Laravel\Rector\Class_\PropertyDeferToDeferrableProviderToRector::class);
};
