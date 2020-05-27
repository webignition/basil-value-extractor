<?php

declare(strict_types=1);

namespace webignition\BasilValueExtractor;

class DescendantIdentifierExtractor
{
    private const DESCENDANT_SEPARATOR = ' >> ';

    private ElementIdentifierExtractor $elementIdentifierExtractor;
    private VariableValueExtractor $variableValueExtractor;

    public function __construct(
        ElementIdentifierExtractor $pageElementIdentifierExtractor,
        VariableValueExtractor $variableValueExtractor
    ) {
        $this->elementIdentifierExtractor = $pageElementIdentifierExtractor;
        $this->variableValueExtractor = $variableValueExtractor;
    }

    public static function createExtractor(): self
    {
        return new DescendantIdentifierExtractor(
            ElementIdentifierExtractor::createExtractor(),
            VariableValueExtractor::createExtractor()
        );
    }

    public function extractIdentifier(string $string): ?string
    {
        $parentIdentifier = $this->extractParentIdentifier($string);
        if (null === $parentIdentifier) {
            return null;
        }

        $childIdentifier = $this->doExtractChildIdentifier($string, $parentIdentifier);
        if (null === $childIdentifier) {
            return null;
        }

        return $parentIdentifier . self::DESCENDANT_SEPARATOR . $childIdentifier;
    }

    public function extractParentIdentifier(string $string): ?string
    {
        $descendantSeparatorLength = strlen(self::DESCENDANT_SEPARATOR);

        $parentIdentifier = '';
        $remainder = $string;

        $firstIdentifier = $this->extractFirstIdentifier($remainder);
        if (null === $firstIdentifier) {
            return null;
        }

        $firstIdentifierLength = strlen($firstIdentifier);
        $remainder = substr($remainder, $firstIdentifierLength);
        $remainderStart = substr($remainder, 0, $descendantSeparatorLength);

        if (self::DESCENDANT_SEPARATOR !== $remainderStart) {
            return null;
        }

        while ($remainderStart === self::DESCENDANT_SEPARATOR) {
            $parentIdentifier .= $firstIdentifier . self::DESCENDANT_SEPARATOR;
            $remainder = substr($remainder, $descendantSeparatorLength);

            $firstIdentifier = $this->extractFirstIdentifier($remainder);
            if (null === $firstIdentifier) {
                return $this->rtrimDescendantSeparator($parentIdentifier);
            }

            $firstIdentifierLength = strlen($firstIdentifier);
            $remainder = substr($remainder, $firstIdentifierLength);
            $remainderStart = substr($remainder, 0, $descendantSeparatorLength);
        }

        return $this->rtrimDescendantSeparator($parentIdentifier);
    }

    public function extractChildIdentifier(string $string): ?string
    {
        $parentIdentifier = $this->extractParentIdentifier($string);
        if (null === $parentIdentifier) {
            return null;
        }

        return $this->doExtractChildIdentifier($string, $parentIdentifier);
    }

    private function extractFirstIdentifier(string $string): ?string
    {
        $identifier = $this->elementIdentifierExtractor->extract($string);
        if (null !== $identifier) {
            return $identifier;
        }

        return $this->variableValueExtractor->extract($string);
    }

    private function doExtractChildIdentifier(string $string, string $parentIdentifier): ?string
    {
        $childComponent = substr($string, strlen($parentIdentifier));
        $childComponent = $this->ltrimDescendantSeparator($childComponent);


        $childIdentifier = $this->elementIdentifierExtractor->extract($childComponent);
        if (null === $childIdentifier) {
            return null;
        }

        return $childIdentifier;
    }

    private function rtrimDescendantSeparator(string $string): string
    {
        $descendantSeparatorLength = strlen(self::DESCENDANT_SEPARATOR);
        $stringEnd = substr($string, $descendantSeparatorLength * -1);

        if (self::DESCENDANT_SEPARATOR === $stringEnd) {
            $string = substr($string, 0, strlen($string) - $descendantSeparatorLength);
        }

        return $string;
    }

    private function ltrimDescendantSeparator(string $string): string
    {
        $descendantSeparatorLength = strlen(self::DESCENDANT_SEPARATOR);
        $stringStart = substr($string, 0, $descendantSeparatorLength);

        if (self::DESCENDANT_SEPARATOR === $stringStart) {
            $string = substr($string, $descendantSeparatorLength);
        }

        return $string;
    }
}
