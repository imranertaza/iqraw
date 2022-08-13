<?php

declare (strict_types=1);
namespace RectorPrefix20220531\Doctrine\Inflector\Rules;

class Ruleset
{
    /** @var Transformations */
    private $regular;
    /** @var Patterns */
    private $uninflected;
    /** @var Substitutions */
    private $irregular;
    public function __construct(\RectorPrefix20220531\Doctrine\Inflector\Rules\Transformations $regular, \RectorPrefix20220531\Doctrine\Inflector\Rules\Patterns $uninflected, \RectorPrefix20220531\Doctrine\Inflector\Rules\Substitutions $irregular)
    {
        $this->regular = $regular;
        $this->uninflected = $uninflected;
        $this->irregular = $irregular;
    }
    public function getRegular() : \RectorPrefix20220531\Doctrine\Inflector\Rules\Transformations
    {
        return $this->regular;
    }
    public function getUninflected() : \RectorPrefix20220531\Doctrine\Inflector\Rules\Patterns
    {
        return $this->uninflected;
    }
    public function getIrregular() : \RectorPrefix20220531\Doctrine\Inflector\Rules\Substitutions
    {
        return $this->irregular;
    }
}
