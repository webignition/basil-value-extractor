<?php

declare(strict_types=1);

namespace webignition\BasilValueExtractor;

class ValueExtractor
{
    private $quotedValueExtractor;
    private $identifierExtractor;

    public function __construct(QuotedValueExtractor $quotedValueExtractor, IdentifierExtractor $identifierExtractor)
    {
        $this->quotedValueExtractor = $quotedValueExtractor;
        $this->identifierExtractor = $identifierExtractor;
    }

    public function extract(string $string): ?string
    {
        $value = $this->identifierExtractor->extract($string);
        if (null !== $value) {
            return $value;
        }

        $value = $this->quotedValueExtractor->extract($string);
        if (null !== $value) {
            return $value;
        }

        return null;
    }
}
