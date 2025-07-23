<?php

namespace MartinSoenen\PHPStanRules\Tests\Rules\data\NoBasicExceptionRule;

class BasicExceptionClass
{
    public function doFoo() {
        throw new \Exception("Test exception");
    }
}