<?php

declare(strict_types=1);

namespace webignition\BasilValueExtractor;

class IdentifierExtractor
{
    public function __construct(
        private ElementIdentifierExtractor $elementIdentifierExtractor,
        private VariableValueExtractor $variableValueExtractor,
        private DescendantIdentifierExtractor $descendantIdentifierExtractor
    ) {
    }

    public static function createExtractor(): self
    {
        return new IdentifierExtractor(
            ElementIdentifierExtractor::createExtractor(),
            VariableValueExtractor::createExtractor(),
            DescendantIdentifierExtractor::createExtractor()
        );
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
