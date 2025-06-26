<?php

namespace MartinSoenen\PHPStanRules\Tests\Rules\data\NoTryCatchRule;

class TryCatch
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