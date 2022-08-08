<?php

declare (strict_types=1);
namespace Rector\DowngradePhp81\Rector\Array_;

use PhpParser\Node;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\ArrayItem;
use PHPStan\Analyser\Scope;
use PHPStan\Type\ArrayType;
use PHPStan\Type\IntegerType;
use Rector\Core\Rector\AbstractScopeAwareRector;
use Rector\DowngradePhp81\NodeAnalyzer\ArraySpreadAnalyzer;
use Rector\DowngradePhp81\NodeFactory\ArrayMergeFromArraySpreadFactory;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @changelog https://wiki.php.net/rfc/array_unpacking_string_keys
 *
 * @see \Rector\Tests\DowngradePhp81\Rector\Array_\DowngradeArraySpreadStringKeyRector\DowngradeArraySpreadStringKeyRectorTest
 */
final class DowngradeArraySpreadStringKeyRector extends \Rector\Core\Rector\AbstractScopeAwareRector
{
    /**
     * @readonly
     * @var \Rector\DowngradePhp81\NodeFactory\ArrayMergeFromArraySpreadFactory
     */
    private $arrayMergeFromArraySpreadFactory;
    /**
     * @readonly
     * @var \Rector\DowngradePhp81\NodeAnalyzer\ArraySpreadAnalyzer
     */
    private $arraySpreadAnalyzer;
    public function __construct(\Rector\DowngradePhp81\NodeFactory\ArrayMergeFromArraySpreadFactory $arrayMergeFromArraySpreadFactory, \Rector\DowngradePhp81\NodeAnalyzer\ArraySpreadAnalyzer $arraySpreadAnalyzer)
    {
        $this->arrayMergeFromArraySpreadFactory = $arrayMergeFromArraySpreadFactory;
        $this->arraySpreadAnalyzer = $arraySpreadAnalyzer;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Replace array spread with string key to array_merge function', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
$parts = ['a' => 'b'];
$parts2 = ['c' => 'd'];

$result = [...$parts, ...$parts2];
CODE_SAMPLE
, <<<'CODE_SAMPLE'
$parts = ['a' => 'b'];
$parts2 = ['c' => 'd'];

$result = array_merge($parts, $parts2);
CODE_SAMPLE
)]);
    }
    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Expr\Array_::class];
    }
    /**
     * @param Array_ $node
     */
    public function refactorWithScope(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope) : ?\PhpParser\Node
    {
        if ($this->shouldSkipArray($node)) {
            return null;
        }
        return $this->arrayMergeFromArraySpreadFactory->createFromArray($node, $scope, $this->file);
    }
    private function shouldSkipArray(\PhpParser\Node\Expr\Array_ $array) : bool
    {
        if (!$this->arraySpreadAnalyzer->isArrayWithUnpack($array)) {
            return \true;
        }
        foreach ($array->items as $item) {
            if (!$item instanceof \PhpParser\Node\Expr\ArrayItem) {
                continue;
            }
            $type = $this->nodeTypeResolver->getType($item->value);
            if (!$type instanceof \PHPStan\Type\ArrayType) {
                continue;
            }
            $keyType = $type->getKeyType();
            if ($keyType instanceof \PHPStan\Type\IntegerType) {
                return \true;
            }
        }
        return \false;
    }
}
