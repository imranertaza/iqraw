<?php

declare (strict_types=1);
namespace Rector\Core\Util;

use RectorPrefix20220531\Nette\Utils\Strings;
final class StringUtils
{
    public static function isMatch(string $value, string $regex) : bool
    {
        $match = \RectorPrefix20220531\Nette\Utils\Strings::match($value, $regex);
        return $match !== null;
    }
}
