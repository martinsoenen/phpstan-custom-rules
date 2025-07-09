<?php declare(strict_types = 1);

namespace MartinSoenen\PHPStanRules\Tests\Rules;

use MartinSoenen\PHPStanRules\Rules\MaxLinePerMethodRule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<MaxLinePerMethodRule>
 */
class MaxLinePerMethodRuleTest extends RuleTestCase
{
    protected function getRule(): \PHPStan\Rules\Rule
    {
        // getRule() method needs to return an instance of the tested rule
        return new MaxLinePerMethodRule();
    }

    public function testWithMultipleLines(): void
    {
        // first argument: path to the example file that contains some errors that should be reported by MyRule
        // second argument: an array of expected errors,
        // each error consists of the asserted error message, and the asserted error file line
        $this->analyse([__DIR__ . '/data/MaxLinePerMethodRule/MultipleLinesMethods.php'], [
            [
                "The twentyOneLines function has more than 20 code lines. Please reduce it.", // asserted error message
                53, // asserted error line
            ],
        ]);
    }

    public function testWithOneLine(): void
    {
        $this->analyse([__DIR__ . '/data/MaxLinePerMethodRule/OneLineMethods.php'], []);
    }

    public function testWithNoMethods(): void
    {
        $this->analyse([__DIR__ . '/data/MaxLinePerMethodRule/NoMethods.php'], []);
    }
}
