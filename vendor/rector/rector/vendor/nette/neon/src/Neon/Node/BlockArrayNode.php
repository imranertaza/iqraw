<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace RectorPrefix20220531\Nette\Neon\Node;

/** @internal */
final class BlockArrayNode extends \RectorPrefix20220531\Nette\Neon\Node\ArrayNode
{
    /** @var string */
    public $indentation;
    public function __construct(string $indentation = '')
    {
        $this->indentation = $indentation;
    }
    public function toString() : string
    {
        if (\count($this->items) === 0) {
            return '[]';
        }
        $res = \RectorPrefix20220531\Nette\Neon\Node\ArrayItemNode::itemsToBlockString($this->items);
        return \preg_replace('#^(?=.)#m', $this->indentation, $res);
    }
}
