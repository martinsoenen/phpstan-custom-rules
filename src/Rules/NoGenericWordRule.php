<?php

namespace MartinSoenen\PHPStanRules\Rules;

use PhpParser\Node;
use PhpParser\Node\Expr\Variable;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

class NoGenericWordRule implements Rule
{
    private const FORBIDDEN_VARIABLE_NAMES = [
        'arr',
        'array',
        'bool',
        'collection',
        'context',
        'data',
        'entity',
        'handle',
        'id',
        'index',
        'instance',
        'iterator',
        'item',
        'key',
        'list',
        'map',
        'model',
        'number',
        'num',
        'object',
        'obj',
        'ref',
        'res',
        'result',
        'str',
        'string',
        'temp',
        'val',
        'value',
        'var',
        'variable'
    ];

    public function getNodeType(): string
    {
        return Variable::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        $varName = $node->name;
        if (in_array($varName, self::FORBIDDEN_VARIABLE_NAMES)) {
            return [
                RuleErrorBuilder::message(
                    sprintf(
                        'Variable name "%s" is too generic. Please use a more descriptive name.',
                        $varName
                    )
                )
                ->line($node->getLine())
                ->identifier('martinsoenen.noGenericWord')
                ->build()
            ];
        }

        return [];
    }
}
