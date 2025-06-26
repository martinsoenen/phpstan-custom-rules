<?php

namespace MartinSoenen\PHPStanRules\Tests\Rules\data\NoLaravelObserverRule;

class NoObserveMethod
{
    public function boot() {}

    private static function observe() {}
}