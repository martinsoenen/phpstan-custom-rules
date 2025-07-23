<?php

namespace MartinSoenen\PHPStanRules\Tests\Rules\data\NoBasicExceptionRule;

use MartinSoenen\PHPStanRules\Tests\Rules\data\FooException;

class AdvancedExceptionClass
{
    public function doFoo() {
        throw new FooException("Test exception");
    }
}