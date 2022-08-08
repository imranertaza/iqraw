<?php

declare (strict_types=1);
namespace Rector\TypeDeclaration\TypeInferer\ReturnTypeInferer;

use PhpParser\Node\FunctionLike;
use PhpParser\Node\Stmt\ClassLike;
use PhpParser\Node\Stmt\Property;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\Php\PhpPropertyReflection;
use PHPStan\Type\MixedType;
use PHPStan\Type\Type;
use Rector\Core\NodeManipulator\FunctionLikeManipulator;
use Rector\Core\PhpParser\AstResolver;
use Rector\Core\PhpParser\Node\BetterNodeFinder;
use Rector\Core\Reflection\ReflectionResolver;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\NodeTypeResolver\PHPStan\Type\TypeFactory;
use Rector\TypeDeclaration\Contract\TypeInferer\ReturnTypeInfererInterface;
use Rector\TypeDeclaration\TypeInferer\AssignToPropertyTypeInferer;
final class SetterNodeReturnTypeInfererTypeInferer implements \Rector\TypeDeclaration\Contract\TypeInferer\ReturnTypeInfererInterface
{
    /**
     * @readonly
     * @var \Rector\TypeDeclaration\TypeInferer\AssignToPropertyTypeInferer
     */
    private $assignToPropertyTypeInferer;
    /**
     * @readonly
     * @var \Rector\Core\NodeManipulator\FunctionLikeManipulator
     */
    private $functionLikeManipulator;
    /**
     * @readonly
     * @var \Rector\NodeTypeResolver\PHPStan\Type\TypeFactory
     */
    private $typeFactory;
    /**
     * @readonly
     * @var \Rector\Core\PhpParser\Node\BetterNodeFinder
     */
    private $betterNodeFinder;
    /**
     * @readonly
     * @var \Rector\Core\PhpParser\AstResolver
     */
    private $astResolver;
    /**
     * @readonly
     * @var \Rector\Core\Reflection\ReflectionResolver
     */
    private $reflectionResolver;
    public function __construct(\Rector\TypeDeclaration\TypeInferer\AssignToPropertyTypeInferer $assignToPropertyTypeInferer, \Rector\Core\NodeManipulator\FunctionLikeManipulator $functionLikeManipulator, \Rector\NodeTypeResolver\PHPStan\Type\TypeFactory $typeFactory, \Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \Rector\Core\PhpParser\AstResolver $astResolver, \Rector\Core\Reflection\ReflectionResolver $reflectionResolver)
    {
        $this->assignToPropertyTypeInferer = $assignToPropertyTypeInferer;
        $this->functionLikeManipulator = $functionLikeManipulator;
        $this->typeFactory = $typeFactory;
        $this->betterNodeFinder = $betterNodeFinder;
        $this->astResolver = $astResolver;
        $this->reflectionResolver = $reflectionResolver;
    }
    public function inferFunctionLike(\PhpParser\Node\FunctionLike $functionLike) : \PHPStan\Type\Type
    {
        $classLike = $this->betterNodeFinder->findParentType($functionLike, \PhpParser\Node\Stmt\ClassLike::class);
        if (!$classLike instanceof \PhpParser\Node\Stmt\ClassLike) {
            return new \PHPStan\Type\MixedType();
        }
        $returnedPropertyNames = $this->functionLikeManipulator->getReturnedLocalPropertyNames($functionLike);
        $classReflection = $this->reflectionResolver->resolveClassReflection($classLike);
        if (!$classReflection instanceof \PHPStan\Reflection\ClassReflection) {
            return new \PHPStan\Type\MixedType();
        }
        $types = [];
        $scope = $classLike->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        foreach ($returnedPropertyNames as $returnedPropertyName) {
            if (!$classReflection->hasProperty($returnedPropertyName)) {
                continue;
            }
            $propertyReflection = $classReflection->getProperty($returnedPropertyName, $scope);
            if (!$propertyReflection instanceof \PHPStan\Reflection\Php\PhpPropertyReflection) {
                continue;
            }
            $property = $this->astResolver->resolvePropertyFromPropertyReflection($propertyReflection);
            if (!$property instanceof \PhpParser\Node\Stmt\Property) {
                continue;
            }
            $inferredPropertyType = $this->assignToPropertyTypeInferer->inferPropertyInClassLike($property, $returnedPropertyName, $classLike);
            if (!$inferredPropertyType instanceof \PHPStan\Type\Type) {
                continue;
            }
            $types[] = $inferredPropertyType;
        }
        return $this->typeFactory->createMixedPassedOrUnionType($types);
    }
    public function getPriority() : int
    {
        return 600;
    }
}
