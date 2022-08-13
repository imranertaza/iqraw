<?php

declare (strict_types=1);
namespace Rector\NodeTypeResolver\TypeComparator;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PHPStan\PhpDocParser\Ast\PhpDoc\ParamTagValueNode;
use PHPStan\PhpDocParser\Ast\Type\TypeNode;
use PHPStan\Type\ArrayType;
use PHPStan\Type\BooleanType;
use PHPStan\Type\Constant\ConstantArrayType;
use PHPStan\Type\Constant\ConstantBooleanType;
use PHPStan\Type\ConstantScalarType;
use PHPStan\Type\Generic\GenericClassStringType;
use PHPStan\Type\IntegerType;
use PHPStan\Type\MixedType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\StaticType;
use PHPStan\Type\ThisType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeTraverser;
use PHPStan\Type\UnionType;
use Rector\BetterPhpDocParser\ValueObject\PhpDocAttributeKey;
use Rector\Core\PhpParser\Node\BetterNodeFinder;
use Rector\NodeTypeResolver\PHPStan\Type\TypeFactory;
use Rector\NodeTypeResolver\PHPStan\TypeHasher;
use Rector\PHPStanStaticTypeMapper\TypeAnalyzer\UnionTypeAnalyzer;
use Rector\StaticTypeMapper\StaticTypeMapper;
use Rector\StaticTypeMapper\ValueObject\Type\AliasedObjectType;
use Rector\TypeDeclaration\TypeNormalizer;
final class TypeComparator
{
    /**
     * @readonly
     * @var \Rector\NodeTypeResolver\PHPStan\TypeHasher
     */
    private $typeHasher;
    /**
     * @readonly
     * @var \Rector\TypeDeclaration\TypeNormalizer
     */
    private $typeNormalizer;
    /**
     * @readonly
     * @var \Rector\StaticTypeMapper\StaticTypeMapper
     */
    private $staticTypeMapper;
    /**
     * @readonly
     * @var \Rector\NodeTypeResolver\TypeComparator\ArrayTypeComparator
     */
    private $arrayTypeComparator;
    /**
     * @readonly
     * @var \Rector\NodeTypeResolver\TypeComparator\ScalarTypeComparator
     */
    private $scalarTypeComparator;
    /**
     * @readonly
     * @var \Rector\NodeTypeResolver\PHPStan\Type\TypeFactory
     */
    private $typeFactory;
    /**
     * @readonly
     * @var \Rector\PHPStanStaticTypeMapper\TypeAnalyzer\UnionTypeAnalyzer
     */
    private $unionTypeAnalyzer;
    /**
     * @readonly
     * @var \Rector\Core\PhpParser\Node\BetterNodeFinder
     */
    private $betterNodeFinder;
    public function __construct(\Rector\NodeTypeResolver\PHPStan\TypeHasher $typeHasher, \Rector\TypeDeclaration\TypeNormalizer $typeNormalizer, \Rector\StaticTypeMapper\StaticTypeMapper $staticTypeMapper, \Rector\NodeTypeResolver\TypeComparator\ArrayTypeComparator $arrayTypeComparator, \Rector\NodeTypeResolver\TypeComparator\ScalarTypeComparator $scalarTypeComparator, \Rector\NodeTypeResolver\PHPStan\Type\TypeFactory $typeFactory, \Rector\PHPStanStaticTypeMapper\TypeAnalyzer\UnionTypeAnalyzer $unionTypeAnalyzer, \Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder)
    {
        $this->typeHasher = $typeHasher;
        $this->typeNormalizer = $typeNormalizer;
        $this->staticTypeMapper = $staticTypeMapper;
        $this->arrayTypeComparator = $arrayTypeComparator;
        $this->scalarTypeComparator = $scalarTypeComparator;
        $this->typeFactory = $typeFactory;
        $this->unionTypeAnalyzer = $unionTypeAnalyzer;
        $this->betterNodeFinder = $betterNodeFinder;
    }
    public function areTypesEqual(\PHPStan\Type\Type $firstType, \PHPStan\Type\Type $secondType) : bool
    {
        $firstTypeHash = $this->typeHasher->createTypeHash($firstType);
        $secondTypeHash = $this->typeHasher->createTypeHash($secondType);
        if ($firstTypeHash === $secondTypeHash) {
            return \true;
        }
        if ($this->scalarTypeComparator->areEqualScalar($firstType, $secondType)) {
            return \true;
        }
        // aliases and types
        if ($this->areAliasedObjectMatchingFqnObject($firstType, $secondType)) {
            return \true;
        }
        if ($this->areArrayUnionConstantEqualTypes($firstType, $secondType)) {
            return \true;
        }
        $firstType = $this->typeNormalizer->normalizeArrayOfUnionToUnionArray($firstType);
        $secondType = $this->typeNormalizer->normalizeArrayOfUnionToUnionArray($secondType);
        if ($this->typeHasher->areTypesEqual($firstType, $secondType)) {
            return \true;
        }
        // is template of
        return $this->areArrayTypeWithSingleObjectChildToParent($firstType, $secondType);
    }
    public function arePhpParserAndPhpStanPhpDocTypesEqual(\PhpParser\Node $phpParserNode, \PHPStan\PhpDocParser\Ast\Type\TypeNode $phpStanDocTypeNode, \PhpParser\Node $node) : bool
    {
        $phpParserNodeType = $this->staticTypeMapper->mapPhpParserNodePHPStanType($phpParserNode);
        $phpStanDocType = $this->staticTypeMapper->mapPHPStanPhpDocTypeNodeToPHPStanType($phpStanDocTypeNode, $node);
        // normalize bool union types
        $phpParserNodeType = $this->normalizeConstantBooleanType($phpParserNodeType);
        $phpStanDocType = $this->normalizeConstantBooleanType($phpStanDocType);
        // is scalar replace by another - remove it?
        $areDifferentScalarTypes = $this->scalarTypeComparator->areDifferentScalarTypes($phpParserNodeType, $phpStanDocType);
        if (!$areDifferentScalarTypes && !$this->areTypesEqual($phpParserNodeType, $phpStanDocType)) {
            return \false;
        }
        if ($this->isTypeSelfAndDocParamTypeStatic($phpStanDocType, $phpParserNodeType, $phpStanDocTypeNode)) {
            return \false;
        }
        if ($this->areTypesSameWithLiteralTypeInPhpDoc($areDifferentScalarTypes, $phpStanDocType, $phpParserNodeType)) {
            return \false;
        }
        return $this->isThisTypeInFinalClass($phpStanDocType, $phpParserNodeType, $phpParserNode);
    }
    public function isSubtype(\PHPStan\Type\Type $checkedType, \PHPStan\Type\Type $mainType) : bool
    {
        if ($mainType instanceof \PHPStan\Type\MixedType) {
            return \false;
        }
        if (!$mainType instanceof \PHPStan\Type\ArrayType) {
            return $mainType->isSuperTypeOf($checkedType)->yes();
        }
        if (!$checkedType instanceof \PHPStan\Type\ArrayType) {
            return $mainType->isSuperTypeOf($checkedType)->yes();
        }
        return $this->arrayTypeComparator->isSubtype($checkedType, $mainType);
    }
    public function areTypesPossiblyIncluded(?\PHPStan\Type\Type $assumptionType, ?\PHPStan\Type\Type $exactType) : bool
    {
        if (!$assumptionType instanceof \PHPStan\Type\Type) {
            return \true;
        }
        if (!$exactType instanceof \PHPStan\Type\Type) {
            return \true;
        }
        if ($this->areTypesEqual($assumptionType, $exactType)) {
            return \true;
        }
        if (!$assumptionType instanceof \PHPStan\Type\UnionType) {
            return \true;
        }
        if (!$exactType instanceof \PHPStan\Type\UnionType) {
            return \true;
        }
        $countAssumpionTypeTypes = \count($assumptionType->getTypes());
        $countExactTypeTypes = \count($exactType->getTypes());
        if ($countAssumpionTypeTypes === $countExactTypeTypes) {
            $unionType = $this->unionTypeAnalyzer->mapGenericToClassStringType($exactType);
            return $this->areTypesEqual($assumptionType, $unionType);
        }
        return $countAssumpionTypeTypes > $countExactTypeTypes;
    }
    private function areAliasedObjectMatchingFqnObject(\PHPStan\Type\Type $firstType, \PHPStan\Type\Type $secondType) : bool
    {
        if ($firstType instanceof \Rector\StaticTypeMapper\ValueObject\Type\AliasedObjectType && $secondType instanceof \PHPStan\Type\ObjectType) {
            return $firstType->getFullyQualifiedName() === $secondType->getClassName();
        }
        if (!$firstType instanceof \PHPStan\Type\ObjectType) {
            return \false;
        }
        if (!$secondType instanceof \Rector\StaticTypeMapper\ValueObject\Type\AliasedObjectType) {
            return \false;
        }
        return $secondType->getFullyQualifiedName() === $firstType->getClassName();
    }
    /**
     * E.g. class A extends B, class B → A[] is subtype of B[] → keep A[]
     */
    private function areArrayTypeWithSingleObjectChildToParent(\PHPStan\Type\Type $firstType, \PHPStan\Type\Type $secondType) : bool
    {
        if (!$firstType instanceof \PHPStan\Type\ArrayType) {
            return \false;
        }
        if (!$secondType instanceof \PHPStan\Type\ArrayType) {
            return \false;
        }
        $firstArrayItemType = $firstType->getItemType();
        $secondArrayItemType = $secondType->getItemType();
        if ($this->isMutualObjectSubtypes($firstArrayItemType, $secondArrayItemType)) {
            return \true;
        }
        if (!$firstArrayItemType instanceof \PHPStan\Type\Generic\GenericClassStringType) {
            return \false;
        }
        if (!$secondArrayItemType instanceof \PHPStan\Type\Generic\GenericClassStringType) {
            return \false;
        }
        // @todo resolve later better with template map, @see https://github.com/symplify/symplify/pull/3034/commits/4f6be8b87e52117b1aa1613b9b689ae958a9d6f4
        return $firstArrayItemType->getGenericType() instanceof \PHPStan\Type\ObjectType && $secondArrayItemType->getGenericType() instanceof \PHPStan\Type\ObjectType;
    }
    private function isMutualObjectSubtypes(\PHPStan\Type\Type $firstArrayItemType, \PHPStan\Type\Type $secondArrayItemType) : bool
    {
        if (!$firstArrayItemType instanceof \PHPStan\Type\ObjectType) {
            return \false;
        }
        if (!$secondArrayItemType instanceof \PHPStan\Type\ObjectType) {
            return \false;
        }
        if ($firstArrayItemType->isSuperTypeOf($secondArrayItemType)->yes()) {
            return \true;
        }
        return $secondArrayItemType->isSuperTypeOf($firstArrayItemType)->yes();
    }
    private function normalizeSingleUnionType(\PHPStan\Type\Type $type) : \PHPStan\Type\Type
    {
        if (!$type instanceof \PHPStan\Type\UnionType) {
            return $type;
        }
        $uniqueTypes = $this->typeFactory->uniquateTypes($type->getTypes());
        if (\count($uniqueTypes) !== 1) {
            return $type;
        }
        return $uniqueTypes[0];
    }
    private function areArrayUnionConstantEqualTypes(\PHPStan\Type\Type $firstType, \PHPStan\Type\Type $secondType) : bool
    {
        if (!$firstType instanceof \PHPStan\Type\ArrayType) {
            return \false;
        }
        if (!$secondType instanceof \PHPStan\Type\ArrayType) {
            return \false;
        }
        if ($firstType instanceof \PHPStan\Type\Constant\ConstantArrayType || $secondType instanceof \PHPStan\Type\Constant\ConstantArrayType) {
            return \false;
        }
        $firstKeyType = $this->normalizeSingleUnionType($firstType->getKeyType());
        $secondKeyType = $this->normalizeSingleUnionType($secondType->getKeyType());
        // mixed and integer type are mutual replaceable in practise
        if ($firstKeyType instanceof \PHPStan\Type\MixedType) {
            $firstKeyType = new \PHPStan\Type\IntegerType();
        }
        if ($secondKeyType instanceof \PHPStan\Type\MixedType) {
            $secondKeyType = new \PHPStan\Type\IntegerType();
        }
        if (!$this->areTypesEqual($firstKeyType, $secondKeyType)) {
            return \false;
        }
        $firstArrayType = $this->normalizeSingleUnionType($firstType->getItemType());
        $secondArrayType = $this->normalizeSingleUnionType($secondType->getItemType());
        return $this->areTypesEqual($firstArrayType, $secondArrayType);
    }
    private function normalizeConstantBooleanType(\PHPStan\Type\Type $type) : \PHPStan\Type\Type
    {
        return \PHPStan\Type\TypeTraverser::map($type, function (\PHPStan\Type\Type $type, callable $callable) : Type {
            if ($type instanceof \PHPStan\Type\Constant\ConstantBooleanType) {
                return new \PHPStan\Type\BooleanType();
            }
            return $callable($type);
        });
    }
    private function isTypeSelfAndDocParamTypeStatic(\PHPStan\Type\Type $phpStanDocType, \PHPStan\Type\Type $phpParserNodeType, \PHPStan\PhpDocParser\Ast\Type\TypeNode $phpStanDocTypeNode) : bool
    {
        return $phpStanDocType instanceof \PHPStan\Type\StaticType && $phpParserNodeType instanceof \PHPStan\Type\ThisType && $phpStanDocTypeNode->getAttribute(\Rector\BetterPhpDocParser\ValueObject\PhpDocAttributeKey::PARENT) instanceof \PHPStan\PhpDocParser\Ast\PhpDoc\ParamTagValueNode;
    }
    private function areTypesSameWithLiteralTypeInPhpDoc(bool $areDifferentScalarTypes, \PHPStan\Type\Type $phpStanDocType, \PHPStan\Type\Type $phpParserNodeType) : bool
    {
        return $areDifferentScalarTypes && $phpStanDocType instanceof \PHPStan\Type\ConstantScalarType && $phpParserNodeType->isSuperTypeOf($phpStanDocType)->yes();
    }
    private function isThisTypeInFinalClass(\PHPStan\Type\Type $phpStanDocType, \PHPStan\Type\Type $phpParserNodeType, \PhpParser\Node $node) : bool
    {
        /**
         * Special case for $this/(self|static) compare
         *
         * $this refers to the exact object identity, not just the same type. Therefore, it's valid and should not be removed
         * @see https://wiki.php.net/rfc/this_return_type for more context
         */
        if ($phpStanDocType instanceof \PHPStan\Type\ThisType && $phpParserNodeType instanceof \PHPStan\Type\StaticType) {
            return \false;
        }
        $isStaticReturnDocTypeWithThisType = $phpStanDocType instanceof \PHPStan\Type\StaticType && $phpParserNodeType instanceof \PHPStan\Type\ThisType;
        if (!$isStaticReturnDocTypeWithThisType) {
            return \true;
        }
        $class = $this->betterNodeFinder->findParentType($node, \PhpParser\Node\Stmt\Class_::class);
        if (!$class instanceof \PhpParser\Node\Stmt\Class_) {
            return \false;
        }
        return $class->isFinal();
    }
}
