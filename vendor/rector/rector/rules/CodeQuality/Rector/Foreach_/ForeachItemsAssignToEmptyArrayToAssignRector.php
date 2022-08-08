<?php

declare (strict_types=1);
namespace Rector\CodeQuality\Rector\Foreach_;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Stmt\Foreach_;
use PHPStan\Analyser\Scope;
use PHPStan\Type\ObjectType;
use PHPStan\Type\ThisType;
use Rector\CodeQuality\NodeAnalyzer\ForeachAnalyzer;
use Rector\Core\Rector\AbstractScopeAwareRector;
use Rector\NodeNestingScope\ValueObject\ControlStructure;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\ReadWrite\NodeFinder\NodeUsageFinder;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Tests\CodeQuality\Rector\Foreach_\ForeachItemsAssignToEmptyArrayToAssignRector\ForeachItemsAssignToEmptyArrayToAssignRectorTest
 */
final class ForeachItemsAssignToEmptyArrayToAssignRector extends \Rector\Core\Rector\AbstractScopeAwareRector
{
    /**
     * @readonly
     * @var \Rector\ReadWrite\NodeFinder\NodeUsageFinder
     */
    private $nodeUsageFinder;
    /**
     * @readonly
     * @var \Rector\CodeQuality\NodeAnalyzer\ForeachAnalyzer
     */
    private $foreachAnalyzer;
    public function __construct(\Rector\ReadWrite\NodeFinder\NodeUsageFinder $nodeUsageFinder, \Rector\CodeQuality\NodeAnalyzer\ForeachAnalyzer $foreachAnalyzer)
    {
        $this->nodeUsageFinder = $nodeUsageFinder;
        $this->foreachAnalyzer = $foreachAnalyzer;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change foreach() items assign to empty array to direct assign', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run($items)
    {
        $collectedItems = [];

        foreach ($items as $item) {
             $collectedItems[] = $item;
        }
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run($items)
    {
        $collectedItems = [];

        $collectedItems = $items;
    }
}
CODE_SAMPLE
)]);
    }
    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Stmt\Foreach_::class];
    }
    /**
     * @param Foreach_ $node
     */
    public function refactorWithScope(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope) : ?\PhpParser\Node
    {
        if ($this->shouldSkip($node, $scope)) {
            return null;
        }
        /** @var Expr $assignVariable */
        $assignVariable = $this->foreachAnalyzer->matchAssignItemsOnlyForeachArrayVariable($node);
        return new \PhpParser\Node\Expr\Assign($assignVariable, $node->expr);
    }
    private function shouldSkip(\PhpParser\Node\Stmt\Foreach_ $foreach, \PHPStan\Analyser\Scope $scope) : bool
    {
        $assignVariable = $this->foreachAnalyzer->matchAssignItemsOnlyForeachArrayVariable($foreach);
        if (!$assignVariable instanceof \PhpParser\Node\Expr) {
            return \true;
        }
        if ($this->shouldSkipAsPartOfOtherLoop($foreach)) {
            return \true;
        }
        $previousDeclaration = $this->nodeUsageFinder->findPreviousForeachNodeUsage($foreach, $assignVariable);
        if (!$previousDeclaration instanceof \PhpParser\Node) {
            return \true;
        }
        $previousDeclarationParentNode = $previousDeclaration->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if (!$previousDeclarationParentNode instanceof \PhpParser\Node\Expr\Assign) {
            return \true;
        }
        // must be empty array, otherwise it will false override
        $defaultValue = $this->valueResolver->getValue($previousDeclarationParentNode->expr);
        if ($defaultValue !== []) {
            return \true;
        }
        $type = $scope->getType($foreach->expr);
        if ($type instanceof \PHPStan\Type\ObjectType) {
            return $type->isIterable()->yes();
        }
        if ($type instanceof \PHPStan\Type\ThisType) {
            return $type->isIterable()->yes();
        }
        return \false;
    }
    private function shouldSkipAsPartOfOtherLoop(\PhpParser\Node\Stmt\Foreach_ $foreach) : bool
    {
        $foreachParent = $this->betterNodeFinder->findParentByTypes($foreach, \Rector\NodeNestingScope\ValueObject\ControlStructure::LOOP_NODES);
        return $foreachParent instanceof \PhpParser\Node;
    }
}
