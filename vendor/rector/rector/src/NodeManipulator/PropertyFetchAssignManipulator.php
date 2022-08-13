<?php

declare (strict_types=1);
namespace Rector\Core\NodeManipulator;

use PhpParser\Node;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt\ClassLike;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Property;
use PhpParser\NodeTraverser;
use Rector\Core\NodeAnalyzer\PropertyFetchAnalyzer;
use Rector\Core\PhpParser\Node\BetterNodeFinder;
use Rector\Core\ValueObject\MethodName;
use Rector\NodeNameResolver\NodeNameResolver;
use RectorPrefix20220531\Symplify\Astral\NodeTraverser\SimpleCallableNodeTraverser;
final class PropertyFetchAssignManipulator
{
    /**
     * @readonly
     * @var \Symplify\Astral\NodeTraverser\SimpleCallableNodeTraverser
     */
    private $simpleCallableNodeTraverser;
    /**
     * @readonly
     * @var \Rector\NodeNameResolver\NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @readonly
     * @var \Rector\Core\PhpParser\Node\BetterNodeFinder
     */
    private $betterNodeFinder;
    /**
     * @readonly
     * @var \Rector\Core\NodeAnalyzer\PropertyFetchAnalyzer
     */
    private $propertyFetchAnalyzer;
    public function __construct(\RectorPrefix20220531\Symplify\Astral\NodeTraverser\SimpleCallableNodeTraverser $simpleCallableNodeTraverser, \Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \Rector\Core\NodeAnalyzer\PropertyFetchAnalyzer $propertyFetchAnalyzer)
    {
        $this->simpleCallableNodeTraverser = $simpleCallableNodeTraverser;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->betterNodeFinder = $betterNodeFinder;
        $this->propertyFetchAnalyzer = $propertyFetchAnalyzer;
    }
    public function isAssignedMultipleTimesInConstructor(\PhpParser\Node\Stmt\Property $property) : bool
    {
        $classLike = $this->betterNodeFinder->findParentType($property, \PhpParser\Node\Stmt\ClassLike::class);
        if (!$classLike instanceof \PhpParser\Node\Stmt\ClassLike) {
            return \false;
        }
        $classMethod = $classLike->getMethod(\Rector\Core\ValueObject\MethodName::CONSTRUCT);
        if (!$classMethod instanceof \PhpParser\Node\Stmt\ClassMethod) {
            return \false;
        }
        $count = 0;
        $propertyName = $this->nodeNameResolver->getName($property);
        $this->simpleCallableNodeTraverser->traverseNodesWithCallable((array) $classMethod->getStmts(), function (\PhpParser\Node $node) use($propertyName, $classLike, &$count) : ?int {
            if (!$node instanceof \PhpParser\Node\Expr\Assign) {
                return null;
            }
            if (!$this->propertyFetchAnalyzer->isLocalPropertyFetchName($node->var, $propertyName)) {
                return null;
            }
            $parentClassLike = $this->betterNodeFinder->findParentType($node, \PhpParser\Node\Stmt\ClassLike::class);
            if ($parentClassLike !== $classLike) {
                return null;
            }
            ++$count;
            if ($count === 2) {
                return \PhpParser\NodeTraverser::STOP_TRAVERSAL;
            }
            return null;
        });
        return $count === 2;
    }
    /**
     * @return string[]
     */
    public function getPropertyNamesOfAssignOfVariable(\PhpParser\Node $node, string $paramName) : array
    {
        $propertyNames = [];
        $this->simpleCallableNodeTraverser->traverseNodesWithCallable($node, function (\PhpParser\Node $node) use($paramName, &$propertyNames) {
            if (!$node instanceof \PhpParser\Node\Expr\Assign) {
                return null;
            }
            if (!$this->isVariableAssignToThisPropertyFetch($node, $paramName)) {
                return null;
            }
            /** @var Assign $node */
            $propertyName = $this->nodeNameResolver->getName($node->expr);
            if (\is_string($propertyName)) {
                $propertyNames[] = $propertyName;
            }
            return null;
        });
        return $propertyNames;
    }
    /**
     * Matches:
     * "$this->someValue = $<variableName>;"
     */
    private function isVariableAssignToThisPropertyFetch(\PhpParser\Node\Expr\Assign $assign, string $variableName) : bool
    {
        if (!$assign->expr instanceof \PhpParser\Node\Expr\Variable) {
            return \false;
        }
        if (!$this->nodeNameResolver->isName($assign->expr, $variableName)) {
            return \false;
        }
        if (!$assign->var instanceof \PhpParser\Node\Expr\PropertyFetch) {
            return \false;
        }
        $propertyFetch = $assign->var;
        // must be local property
        return $this->nodeNameResolver->isName($propertyFetch->var, 'this');
    }
}
