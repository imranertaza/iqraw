<?php

declare (strict_types=1);
namespace RectorPrefix20220531;

use Rector\Config\RectorConfig;
use Rector\DeadCode\Rector\ClassLike\RemoveAnnotationRector;
use Rector\Doctrine\Rector\Class_\MoveRepositoryFromParentToConstructorRector;
use Rector\Doctrine\Rector\Class_\RemoveRepositoryFromEntityAnnotationRector;
use Rector\Doctrine\Rector\ClassMethod\ServiceEntityRepositoryParentCallToDIRector;
use Rector\Doctrine\Rector\MethodCall\ReplaceParentRepositoryCallsByRepositoryPropertyRector;
use Rector\Removing\Rector\Class_\RemoveParentRector;
use Rector\Renaming\Rector\PropertyFetch\RenamePropertyRector;
use Rector\Renaming\ValueObject\RenameProperty;
use Rector\Transform\Rector\MethodCall\MethodCallToPropertyFetchRector;
use Rector\Transform\Rector\MethodCall\ReplaceParentCallByPropertyCallRector;
use Rector\Transform\ValueObject\MethodCallToPropertyFetch;
use Rector\Transform\ValueObject\ReplaceParentCallByPropertyCall;
/**
 * @see https://tomasvotruba.com/blog/2017/10/16/how-to-use-repository-with-doctrine-as-service-in-symfony/
 * @see https://tomasvotruba.com/blog/2018/04/02/rectify-turn-repositories-to-services-in-symfony/
 * @see https://getrector.org/blog/2021/02/08/how-to-instantly-decouple-symfony-doctrine-repository-inheritance-to-clean-composition
 */
return static function (\Rector\Config\RectorConfig $rectorConfig) : void {
    # order matters, this needs to be first to correctly detect parent repository
    // covers "extends EntityRepository"
    $rectorConfig->rule(\Rector\Doctrine\Rector\Class_\MoveRepositoryFromParentToConstructorRector::class);
    $rectorConfig->rule(\Rector\Doctrine\Rector\MethodCall\ReplaceParentRepositoryCallsByRepositoryPropertyRector::class);
    $rectorConfig->rule(\Rector\Doctrine\Rector\Class_\RemoveRepositoryFromEntityAnnotationRector::class);
    // covers "extends ServiceEntityRepository"
    // @see https://github.com/doctrine/DoctrineBundle/pull/727/files
    $rectorConfig->rule(\Rector\Doctrine\Rector\ClassMethod\ServiceEntityRepositoryParentCallToDIRector::class);
    $rectorConfig->ruleWithConfiguration(\Rector\Renaming\Rector\PropertyFetch\RenamePropertyRector::class, [new \Rector\Renaming\ValueObject\RenameProperty('Doctrine\\Bundle\\DoctrineBundle\\Repository\\ServiceEntityRepository', '_em', 'entityManager')]);
    $rectorConfig->ruleWithConfiguration(\Rector\DeadCode\Rector\ClassLike\RemoveAnnotationRector::class, ['method']);
    $rectorConfig->ruleWithConfiguration(\Rector\Transform\Rector\MethodCall\ReplaceParentCallByPropertyCallRector::class, [new \Rector\Transform\ValueObject\ReplaceParentCallByPropertyCall('Doctrine\\Bundle\\DoctrineBundle\\Repository\\ServiceEntityRepository', 'createQueryBuilder', 'entityRepository'), new \Rector\Transform\ValueObject\ReplaceParentCallByPropertyCall('Doctrine\\Bundle\\DoctrineBundle\\Repository\\ServiceEntityRepository', 'createResultSetMappingBuilder', 'entityRepository'), new \Rector\Transform\ValueObject\ReplaceParentCallByPropertyCall('Doctrine\\Bundle\\DoctrineBundle\\Repository\\ServiceEntityRepository', 'clear', 'entityRepository'), new \Rector\Transform\ValueObject\ReplaceParentCallByPropertyCall('Doctrine\\Bundle\\DoctrineBundle\\Repository\\ServiceEntityRepository', 'find', 'entityRepository'), new \Rector\Transform\ValueObject\ReplaceParentCallByPropertyCall('Doctrine\\Bundle\\DoctrineBundle\\Repository\\ServiceEntityRepository', 'findBy', 'entityRepository'), new \Rector\Transform\ValueObject\ReplaceParentCallByPropertyCall('Doctrine\\Bundle\\DoctrineBundle\\Repository\\ServiceEntityRepository', 'findAll', 'entityRepository'), new \Rector\Transform\ValueObject\ReplaceParentCallByPropertyCall('Doctrine\\Bundle\\DoctrineBundle\\Repository\\ServiceEntityRepository', 'count', 'entityRepository'), new \Rector\Transform\ValueObject\ReplaceParentCallByPropertyCall('Doctrine\\Bundle\\DoctrineBundle\\Repository\\ServiceEntityRepository', 'getClassName', 'entityRepository'), new \Rector\Transform\ValueObject\ReplaceParentCallByPropertyCall('Doctrine\\Bundle\\DoctrineBundle\\Repository\\ServiceEntityRepository', 'matching', 'entityRepository')]);
    // @@todo
    $rectorConfig->ruleWithConfiguration(\Rector\Transform\Rector\MethodCall\MethodCallToPropertyFetchRector::class, [new \Rector\Transform\ValueObject\MethodCallToPropertyFetch('Doctrine\\Bundle\\DoctrineBundle\\Repository\\ServiceEntityRepository', 'getEntityManager', 'entityManager')]);
    $rectorConfig->ruleWithConfiguration(\Rector\Removing\Rector\Class_\RemoveParentRector::class, ['Doctrine\\Bundle\\DoctrineBundle\\Repository\\ServiceEntityRepository']);
};
