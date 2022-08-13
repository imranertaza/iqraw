<?php

declare (strict_types=1);
namespace Rector\Nette\NodeAnalyzer;

use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt\ClassMethod;
use Rector\Core\PhpParser\Node\BetterNodeFinder;
use Rector\Defluent\NodeAnalyzer\FluentChainMethodCallNodeAnalyzer;
use Rector\NodeNameResolver\NodeNameResolver;
final class MethodCallManipulator
{
    /**
     * @readonly
     * @var \Rector\Core\PhpParser\Node\BetterNodeFinder
     */
    private $betterNodeFinder;
    /**
     * @readonly
     * @var \Rector\NodeNameResolver\NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @readonly
     * @var \Rector\Defluent\NodeAnalyzer\FluentChainMethodCallNodeAnalyzer
     */
    private $fluentChainMethodCallNodeAnalyzer;
    public function __construct(\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \Rector\Defluent\NodeAnalyzer\FluentChainMethodCallNodeAnalyzer $fluentChainMethodCallNodeAnalyzer)
    {
        $this->betterNodeFinder = $betterNodeFinder;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->fluentChainMethodCallNodeAnalyzer = $fluentChainMethodCallNodeAnalyzer;
    }
    /**
     * @return MethodCall[]
     */
    public function findMethodCallsOnVariable(\PhpParser\Node\Expr\Variable $variable) : array
    {
        // get scope node, e.g. parent function call, method call or anonymous function
        $classMethod = $this->betterNodeFinder->findParentType($variable, \PhpParser\Node\Stmt\ClassMethod::class);
        if (!$classMethod instanceof \PhpParser\Node\Stmt\ClassMethod) {
            return [];
        }
        $variableName = $this->nodeNameResolver->getName($variable);
        if ($variableName === null) {
            return [];
        }
        /** @var MethodCall[] $methodCalls */
        $methodCalls = $this->betterNodeFinder->findInstanceOf($classMethod, \PhpParser\Node\Expr\MethodCall::class);
        return \array_filter($methodCalls, function (\PhpParser\Node\Expr\MethodCall $methodCall) use($variableName) : bool {
            // cover fluent interfaces too
            $callerNode = $this->fluentChainMethodCallNodeAnalyzer->resolveRootExpr($methodCall);
            if (!$callerNode instanceof \PhpParser\Node\Expr\Variable) {
                return \false;
            }
            return $this->nodeNameResolver->isName($callerNode, $variableName);
        });
    }
}
