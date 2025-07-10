<?php declare(strict_types = 1);

namespace MartinSoenen\PHPStanRules\Tests\Rules;

use MartinSoenen\PHPStanRules\Rules\NoDeleteCascadeLaravel;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<NoDeleteCascadeLaravel>
 */
class NoDeleteCascadeLaravelTest extends RuleTestCase
{
    protected function getRule(): Rule
    {
        return new NoDeleteCascadeLaravel();
    }

    public function testRuleDetectsCascade(): void
    {
        $this->analyse([__DIR__ . '/data/NoDeleteCascadeLaravel/BadMigration.php'], [
            ['Cascade delete detected in migration. Please do not delete cascade on the database. Handle it in the code instead.', 22],
            ['Cascade delete detected in migration. Please do not delete cascade on the database. Handle it in the code instead.', 30],
            ['Cascade delete detected in migration. Please do not delete cascade on the database. Handle it in the code instead.', 37]
        ]);
    }

    public function testRuleWithNoCascadeInFile(): void
    {
        $this->analyse([__DIR__ . '/data/NoDeleteCascadeLaravel/GoodMigration.php'], []);
    }

    public function testRuleWorksOnlyOnLaravelMigrations(): void
    {
        $this->analyse([__DIR__ . '/data/NoDeleteCascadeLaravel/NotALaravelMigration.php'], []);
    }
}