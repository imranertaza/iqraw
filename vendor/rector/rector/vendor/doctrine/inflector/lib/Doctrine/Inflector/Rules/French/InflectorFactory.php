<?php

declare (strict_types=1);
namespace RectorPrefix20220531\Doctrine\Inflector\Rules\French;

use RectorPrefix20220531\Doctrine\Inflector\GenericLanguageInflectorFactory;
use RectorPrefix20220531\Doctrine\Inflector\Rules\Ruleset;
final class InflectorFactory extends \RectorPrefix20220531\Doctrine\Inflector\GenericLanguageInflectorFactory
{
    protected function getSingularRuleset() : \RectorPrefix20220531\Doctrine\Inflector\Rules\Ruleset
    {
        return \RectorPrefix20220531\Doctrine\Inflector\Rules\French\Rules::getSingularRuleset();
    }
    protected function getPluralRuleset() : \RectorPrefix20220531\Doctrine\Inflector\Rules\Ruleset
    {
        return \RectorPrefix20220531\Doctrine\Inflector\Rules\French\Rules::getPluralRuleset();
    }
}
