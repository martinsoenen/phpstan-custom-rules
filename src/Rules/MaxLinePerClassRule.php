<?php

namespace MartinSoenen\PHPStanRules\Rules;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PHPStan\Rules\Rule;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\RuleErrorBuilder;

class MaxLinePerClassRule implements Rule
{
    private const MAX_LINES = 100;

    public function getNodeType(): string
    {
        return Class_::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        $startLine = $node->getStartLine() + 1;
        $endLine = $node->getEndLine() - 1;
        $lineCount = $endLine - $startLine;

        if ($lineCount > self::MAX_LINES) {
            return [
                RuleErrorBuilder::message(
                    sprintf(
                        'The %s class has more than %d code lines. Please reduce it.',
                        $node->name->toString(),
                        self::MAX_LINES
                    )
                )
                ->line($node->getLine())
                ->identifier('martinsoenen.maxLinePerClass')
                ->build(),
            ];
        }

        return [];
    }
}