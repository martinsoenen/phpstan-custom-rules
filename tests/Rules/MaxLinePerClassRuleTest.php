<?php declare(strict_types = 1);

namespace MartinSoenen\PHPStanRules\Tests\Rules;

use MartinSoenen\PHPStanRules\Rules\MaxLinePerClassRule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<MaxLinePerClassRule>
 */
class MaxLinePerClassRuleTest extends RuleTestCase
{
    protected function getRule(): \PHPStan\Rules\Rule
    {
        // getRule() method needs to return an instance of the tested rule
        return new MaxLinePerClassRule();
    }

    public function testRuleDumpAnException(): void
    {
        // first argument: path to the example file that contains some errors that should be reported by MyRule
        // second argument: an array of expected errors,
        // each error consists of the asserted error message, and the asserted error file line
        $this->analyse([__DIR__ . '/data/MaxLinePerClassRule/HundredLinesClass.php'], [
            [
                "The HundredLinesClass class has more than 100 code lines. Please reduce it.", // asserted error message
                5, // asserted error line
            ],
        ]);
    }

    public function testRuleDoesNotDumpException(): void
    {
        $this->analyse([__DIR__ . '/data/MaxLinePerClassRule/NinetyNineLinesClass.php'], []);
    }
}
