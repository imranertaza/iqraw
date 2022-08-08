<?php

declare (strict_types=1);
namespace RectorPrefix20220531\Helmich\TypoScriptParser\Parser;

use ArrayObject;
use RectorPrefix20220531\Helmich\TypoScriptParser\Parser\AST\ObjectPath;
use RectorPrefix20220531\Helmich\TypoScriptParser\Parser\AST\RootObjectPath;
use RectorPrefix20220531\Helmich\TypoScriptParser\Tokenizer\TokenInterface;
class ParserState
{
    /** @var ObjectPath */
    private $context;
    /** @var ArrayObject */
    private $statements;
    /** @var TokenStream */
    private $tokens;
    public function __construct(\RectorPrefix20220531\Helmich\TypoScriptParser\Parser\TokenStream $tokens, \ArrayObject $statements = null)
    {
        if ($statements === null) {
            $statements = new \ArrayObject();
        }
        $this->statements = $statements;
        $this->tokens = $tokens;
        $this->context = new \RectorPrefix20220531\Helmich\TypoScriptParser\Parser\AST\RootObjectPath();
    }
    public function withContext(\RectorPrefix20220531\Helmich\TypoScriptParser\Parser\AST\ObjectPath $context) : self
    {
        $clone = clone $this;
        $clone->context = $context;
        return $clone;
    }
    public function withStatements(\ArrayObject $statements) : self
    {
        $clone = clone $this;
        $clone->statements = $statements;
        return $clone;
    }
    /**
     * @param int $lookAhead
     * @return TokenInterface
     */
    public function token(int $lookAhead = 0) : \RectorPrefix20220531\Helmich\TypoScriptParser\Tokenizer\TokenInterface
    {
        return $this->tokens->current($lookAhead);
    }
    /**
     * @param int $increment
     * @return void
     */
    public function next(int $increment = 1) : void
    {
        $this->tokens->next($increment);
    }
    /**
     * @return bool
     */
    public function hasNext() : bool
    {
        return $this->tokens->valid();
    }
    /**
     * @return ObjectPath
     */
    public function context() : \RectorPrefix20220531\Helmich\TypoScriptParser\Parser\AST\ObjectPath
    {
        return $this->context;
    }
    /**
     * @return ArrayObject
     */
    public function statements() : \ArrayObject
    {
        return $this->statements;
    }
}
