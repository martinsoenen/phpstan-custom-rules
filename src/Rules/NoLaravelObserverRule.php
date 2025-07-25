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
    protected static string $ruleIdentifier = 'martinsoenen.noLaravelObserver';

    public function getNodeType(): string
    {
        return Node::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        $errors = [];

        $this->checkObserveMethod($errors, $node);
        $this->checkClassesAndNamespaces($errors, $node, $scope);
        $this->checkObservedByAttribute($errors, $node);

        return $errors;
    }

    protected function checkObserveMethod(array &$errors, Node $node) : void
    {
        if ($node instanceof Node\Expr\StaticCall && $node->name->toString() === 'observe') {
            $errors[] = RuleErrorBuilder::message('The use of model Observers is forbidden in this project. Please use Event & Listeners instead.')
                ->line($node->getLine())
                ->identifier(self::$ruleIdentifier)
                ->build();
        }
    }

    protected function checkClassesAndNamespaces(array &$errors, Node $node, Scope $scope) : void
    {
        if ($node instanceof Node\Stmt\Class_) {
            $className = $node->name->toString();
            $namespace = $scope->getNamespace();

            if (str_ends_with($className, 'Observer') || str_contains($namespace, 'Observers')) {
                $errors[] = RuleErrorBuilder::message('Observer classes or classes in the Observers namespace are forbidden in this project. Please use Event & Listeners instead.')
                    ->line($node->getLine())
                    ->identifier(self::$ruleIdentifier)
                    ->build();
            }
        }
    }

    protected function checkObservedByAttribute(array &$errors, Node $node) : void
    {
        if ($node instanceof Node\Stmt\Class_) {
            foreach ($node->attrGroups as $attrGroup) {
                foreach ($attrGroup->attrs as $attr) {
                    if ($attr->name->getParts() !== null && in_array('ObservedBy', $attr->name->getParts(), true)) {
                        $errors[] = RuleErrorBuilder::message('The use of the ObservedBy attribute is forbidden in this project. Please use Event & Listeners instead.')
                            ->line($node->getLine())
                            ->identifier(self::$ruleIdentifier)
                            ->build();
                        break 2;
                    }
                }
            }
        }
    }
}
