<?php

namespace MartinSoenen\PHPStanRules\Tests\Rules\data;

class NoTryCatchRuleHasATryCatch
{
    public function index(): bool
    {
        try {
            $a = true;
        } catch (\Throwable $e) {
            return false;
        }
        return true;
    }
}