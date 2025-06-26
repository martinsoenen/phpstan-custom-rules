<?php

namespace MartinSoenen\PHPStanRules\Rules;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * @implements Rule<Node>
 */
class NoLaravelObserverRule implements Rule
{
    public function getNodeType(): string
    {
        return Node::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        $errors = [];

        // Calls on the "observe" method
        if ($node instanceof Node\Expr\StaticCall && $node->name->toString() === 'observe') {
            $errors[] = RuleErrorBuilder::message('The use of model Observers is forbidden in this project. Please use Event & Listeners instead.')->build();
        }

        // Classes named "Observer" or in a namespace containing "Observers"
        if ($node instanceof Node\Stmt\Class_) {
            $className = $node->name->toString();
            $namespace = $scope->getNamespace();

            if (str_ends_with($className, 'Observer') || str_contains($namespace, 'Observers')) {
                $errors[] = RuleErrorBuilder::message('Observer classes or classes in the Observers namespace are forbidden in this project. Please use Event & Listeners instead.')->build();
            }
        }

        // Attribute "ObservedBy"
        if ($node instanceof Node\Stmt\Class_) {
            foreach ($node->attrGroups as $attrGroup) {
                foreach ($attrGroup->attrs as $attr) {
                    if ($attr->name->getParts() !== null && in_array('ObservedBy', $attr->name->getParts(), true)) {
                        $errors[] = RuleErrorBuilder::message('The use of the ObservedBy attribute is forbidden in this project. Please use Event & Listeners instead.')->build();
                        break 2;
                    }
                }
            }
        }

        return $errors;
    }
}
