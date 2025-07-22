<?php declare(strict_types = 1);

namespace MartinSoenen\PHPStanRules\Tests\Rules;

use MartinSoenen\PHPStanRules\Rules\BooleanPropertyNamingRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<BooleanPropertyNamingRule>
 */
class BooleanPropertyNamingRuleTest extends RuleTestCase
{
    protected function getRule(): Rule
    {
        return new BooleanPropertyNamingRule();
    }

    public function testRuleDetectsBadNaming(): void
    {
        $this->analyse([__DIR__ . '/data/BooleanPropertyNamingRule/BooleanBadlyNamedClass.php'], [
            ['A boolean property should start with "is".', 8],
        ]);
    }

    public function testRuleDoesNotDetectsGoodNaming(): void
    {
        $this->analyse([__DIR__ . '/data/BooleanPropertyNamingRule/BooleanWellNamedClass.php'], []);
    }
}