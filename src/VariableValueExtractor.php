<?php

declare(strict_types=1);

namespace webignition\BasilValueExtractor;

class VariableValueExtractor
{
    private const VARIABLE_START_CHARACTER = '$';

    public static function createExtractor(): self
    {
        return new VariableValueExtractor();
    }

    public function extract(string $string): ?string
    {
        if ('' === $string) {
            return null;
        }

        if (self::VARIABLE_START_CHARACTER !== $string[0]) {
            return null;
        }

        $defaultValueDelimiter = '|';

        $length = mb_strlen($string);
        $identifier = '';
        $isInDefaultValue = false;
        $previousCharacter = '';

        for ($i = 0; $i < $length; $i++) {
            $currentCharacter = mb_substr($string, $i, 1);

            if ($defaultValueDelimiter === $currentCharacter) {
                $isInDefaultValue = true;
            }

            if (false === $isInDefaultValue && ' ' === $currentCharacter) {
                return $identifier;
            }

            if (true === $isInDefaultValue && '" ' === $previousCharacter . $currentCharacter) {
                return $identifier;
            }

            $identifier .= $currentCharacter;
            $previousCharacter = $currentCharacter;
        }

        return $identifier;
    }
}
