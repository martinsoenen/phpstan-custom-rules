<?php declare(strict_types = 1);

namespace MartinSoenen\PHPStanRules\Tests\Rules;

use MartinSoenen\PHPStanRules\Rules\NoLaravelObserverRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<NoLaravelObserverRule>
 */
class NoLaravelObserverRuleTest extends RuleTestCase
{
    protected function getRule(): Rule
    {
        return new NoLaravelObserverRule();
    }

    public function testRuleDumpAnExceptionInObserveFunction(): void
    {
        $this->analyse([__DIR__ . '/data/NoLaravelObserverRule/ObserveMethod.php'], [
            ['The use of model Observers is forbidden in this project. Please use Event & Listeners instead.', 8]
        ]);
    }

    public function testRuleDoesNotDumpExceptionInObserveFunction(): void
    {
        $this->analyse([__DIR__ . '/data/NoLaravelObserverRule/NoObserveMethod.php'], []);
    }

    public function testRuleDumpAnExceptionInName(): void
    {
        $this->analyse([__DIR__ . '/data/NoLaravelObserverRule/TestObserver.php'], [
            ['Observer classes or classes in the Observers namespace are forbidden in this project. Please use Event & Listeners instead.', 5]
        ]);
    }

    public function testRuleDoesNotDumpExceptionInName(): void
    {
        $this->analyse([__DIR__ . '/data/NoLaravelObserverRule/TestObserverInTheMiddleOfTheName.php'], []);
    }

    public function testRuleDumpAnExceptionInNamespace(): void
    {
        $this->analyse([__DIR__ . '/data/NoLaravelObserverRule/ObserversInNamespace.php'], [
            ['Observer classes or classes in the Observers namespace are forbidden in this project. Please use Event & Listeners instead.', 5]
        ]);
    }

    public function testRuleDoesNotDumpExceptionInNamespace(): void
    {
        $this->analyse([__DIR__ . '/data/NoLaravelObserverRule/NoObserversInNamespace.php'], []);
    }

    public function testRuleDumpAnExceptionInAttribute(): void
    {
        $this->analyse([__DIR__ . '/data/NoLaravelObserverRule/ObservedByAttribute.php'], [
            ['The use of the ObservedBy attribute is forbidden in this project. Please use Event & Listeners instead.', 5]
        ]);
    }

    public function testRuleDoesNotDumpExceptionInAttribute(): void
    {
        $this->analyse([__DIR__ . '/data/NoLaravelObserverRule/NoObservedByAttribute.php'], []);
    }
}