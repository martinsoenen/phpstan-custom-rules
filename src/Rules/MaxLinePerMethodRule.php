<?php

namespace MartinSoenen\PHPStanRules\Rules;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

class MaxLinePerMethodRule implements Rule
{
    private const MAX_LINES = 20;

    public function getNodeType(): string
    {
        return Node\Stmt\ClassMethod::class;
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
                        'The %s function has more than %d code lines. Please reduce it.',
                        $node->name->toString(),
                        self::MAX_LINES
                    )
                )
                ->line($node->getLine())
                ->build(),
            ];
        }

        return [];
    }
}