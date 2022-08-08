<?php

declare (strict_types=1);
namespace RectorPrefix20220531;

use PHPStan\Type\StringType;
use Rector\Config\RectorConfig;
use Rector\Renaming\Rector\ClassConstFetch\RenameClassConstFetchRector;
use Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\Renaming\ValueObject\MethodCallRename;
use Rector\Renaming\ValueObject\RenameClassConstFetch;
use Rector\Symfony\Set\SymfonySetList;
use Rector\TypeDeclaration\Rector\ClassMethod\AddReturnTypeDeclarationRector;
use Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration;
# https://github.com/symfony/symfony/blob/5.4/UPGRADE-5.3.md
return static function (\Rector\Config\RectorConfig $rectorConfig) : void {
    $rectorConfig->sets([\Rector\Symfony\Set\SymfonySetList::ANNOTATIONS_TO_ATTRIBUTES]);
    $rectorConfig->ruleWithConfiguration(\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class, [
        // @see https://github.com/symfony/symfony/pull/40536
        new \Rector\Renaming\ValueObject\MethodCallRename('Symfony\\Component\\HttpFoundation\\RequestStack', 'getMasterRequest', 'getMainRequest'),
        new \Rector\Renaming\ValueObject\MethodCallRename('Symfony\\Component\\Console\\Helper\\Helper', 'strlen', 'width'),
        new \Rector\Renaming\ValueObject\MethodCallRename('Symfony\\Component\\Console\\Helper\\Helper', 'strlenWithoutDecoration', 'removeDecoration'),
        new \Rector\Renaming\ValueObject\MethodCallRename('Symfony\\Component\\HttpKernel\\Event\\KernelEvent', 'isMasterRequest', 'isMainRequest'),
        new \Rector\Renaming\ValueObject\MethodCallRename('Symfony\\Component\\Security\\Core\\Authentication\\Token\\TokenInterface', 'getUsername', 'getUserIdentifier'),
        new \Rector\Renaming\ValueObject\MethodCallRename('Symfony\\Component\\Security\\Core\\Exception\\UsernameNotFoundException', 'getUsername', 'getUserIdentifier'),
        new \Rector\Renaming\ValueObject\MethodCallRename('Symfony\\Component\\Security\\Core\\Exception\\UsernameNotFoundException', 'setUsername', 'setUserIdentifier'),
        new \Rector\Renaming\ValueObject\MethodCallRename('Symfony\\Component\\Security\\Core\\Authentication\\RememberMe\\PersistentTokenInterface', 'getUsername', 'getUserIdentifier'),
    ]);
    $rectorConfig->ruleWithConfiguration(\Rector\Renaming\Rector\Name\RenameClassRector::class, [
        'Symfony\\Component\\Security\\Core\\Exception\\UsernameNotFoundException' => 'Symfony\\Component\\Security\\Core\\Exception\\UserNotFoundException',
        // @see https://github.com/symfony/symfony/pull/39802
        'Symfony\\Component\\Security\\Core\\Encoder\\EncoderFactoryInterface' => 'Symfony\\Component\\PasswordHasher\\Hasher\\PasswordHasherFactoryInterface',
        'Symfony\\Component\\Security\\Core\\Encoder\\MessageDigestPasswordEncoder' => 'Symfony\\Component\\PasswordHasher\\Hasher\\MessageDigestPasswordHasher',
        'Symfony\\Component\\Security\\Core\\Encoder\\MigratingPasswordEncoder' => 'Symfony\\Component\\PasswordHasher\\Hasher\\MigratingPasswordHasher',
        'Symfony\\Component\\Security\\Core\\Encoder\\NativePasswordEncoder' => 'Symfony\\Component\\PasswordHasher\\Hasher\\NativePasswordHasher',
        'Symfony\\Component\\Security\\Core\\Encoder\\PasswordEncoderInterface' => 'Symfony\\Component\\PasswordHasher\\PasswordHasherInterface',
        'Symfony\\Component\\Security\\Core\\Encoder\\Pbkdf2PasswordEncoder' => 'Symfony\\Component\\PasswordHasher\\Hasher\\Pbkdf2PasswordHasher',
        'Symfony\\Component\\Security\\Core\\Encoder\\PlaintextPasswordEncoder' => 'Symfony\\Component\\PasswordHasher\\Hasher\\PlaintextPasswordHasher',
        'Symfony\\Component\\Security\\Core\\Encoder\\SelfSaltingEncoderInterface' => 'Symfony\\Component\\PasswordHasher\\LegacyPasswordHasherInterface',
        'Symfony\\Component\\Security\\Core\\Encoder\\SodiumPasswordEncoder' => 'Symfony\\Component\\PasswordHasher\\Hasher\\SodiumPasswordHasher',
        'Symfony\\Component\\Security\\Core\\Encoder\\UserPasswordEncoder' => 'Symfony\\Component\\PasswordHasher\\Hasher\\UserPasswordHasher',
        'Symfony\\Component\\Security\\Core\\Encoder\\UserPasswordEncoderInterface' => 'Symfony\\Component\\PasswordHasher\\Hasher\\UserPasswordHasherInterface',
    ]);
    $rectorConfig->ruleWithConfiguration(\Rector\TypeDeclaration\Rector\ClassMethod\AddReturnTypeDeclarationRector::class, [new \Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration('Symfony\\Component\\Mailer\\Transport\\AbstractTransportFactory', 'getEndpoint', new \PHPStan\Type\StringType())]);
    // rename constant
    $rectorConfig->ruleWithConfiguration(\Rector\Renaming\Rector\ClassConstFetch\RenameClassConstFetchRector::class, [
        // @see https://github.com/symfony/symfony/pull/40536
        new \Rector\Renaming\ValueObject\RenameClassConstFetch('Symfony\\Component\\HttpKernel\\HttpKernelInterface', 'MASTER_REQUEST', 'MAIN_REQUEST'),
    ]);
};
