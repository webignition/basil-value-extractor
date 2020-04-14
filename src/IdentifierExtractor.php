<?php

declare(strict_types=1);

namespace webignition\BasilValueExtractor;

class IdentifierExtractor
{
    private $elementIdentifierExtractor;
    private $variableValueExtractor;
    private $descendantIdentifierExtractor;

    public function __construct(
        ElementIdentifierExtractor $elementIdentifierExtractor,
        VariableValueExtractor $variableValueExtractor,
        DescendantIdentifierExtractor $descendantIdentifierExtractor
    ) {
        $this->elementIdentifierExtractor = $elementIdentifierExtractor;
        $this->variableValueExtractor = $variableValueExtractor;
        $this->descendantIdentifierExtractor = $descendantIdentifierExtractor;
    }

    public function extract(string $string): ?string
    {
        $identifier = $this->descendantIdentifierExtractor->extractIdentifier($string);
        if (null !== $identifier) {
            return $identifier;
        }

        $identifier = $this->elementIdentifierExtractor->extract($string);
        if (null !== $identifier) {
            return $identifier;
        }

        $identifier = $this->variableValueExtractor->extract($string);
        if (null !== $identifier) {
            return $identifier;
        }

        return null;
    }
}
