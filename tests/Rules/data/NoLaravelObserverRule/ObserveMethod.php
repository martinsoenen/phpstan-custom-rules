<?php

namespace MartinSoenen\PHPStanRules\Tests\Rules\data\NoLaravelObserverRule;

class ObserveMethod
{
    public function boot() {
        $this::observe();
    }

    private static function observe() {}
}