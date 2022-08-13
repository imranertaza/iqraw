<?php

declare (strict_types=1);
namespace Rector\DeadCode\NodeCollector;

use PhpParser\Node\Param;
use PhpParser\Node\Stmt\ClassMethod;
use Rector\Core\NodeAnalyzer\ParamAnalyzer;
final class UnusedParameterResolver
{
    /**
     * @readonly
     * @var \Rector\Core\NodeAnalyzer\ParamAnalyzer
     */
    private $paramAnalyzer;
    public function __construct(\Rector\Core\NodeAnalyzer\ParamAnalyzer $paramAnalyzer)
    {
        $this->paramAnalyzer = $paramAnalyzer;
    }
    /**
     * @return Param[]
     */
    public function resolve(\PhpParser\Node\Stmt\ClassMethod $classMethod) : array
    {
        /** @var array<int, Param> $unusedParameters */
        $unusedParameters = [];
        foreach ($classMethod->params as $i => $param) {
            // skip property promotion
            /** @var Param $param */
            if ($param->flags !== 0) {
                continue;
            }
            if ($this->paramAnalyzer->isParamUsedInClassMethod($classMethod, $param)) {
                continue;
            }
            $unusedParameters[$i] = $param;
        }
        return $unusedParameters;
    }
}
