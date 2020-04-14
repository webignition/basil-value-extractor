<?php

declare(strict_types=1);

namespace webignition\BasilValueExtractor\Tests\DataProvider;

trait QuotedValueDataProviderTrait
{
    public function quotedValueDataProvider(): array
    {
        return [
            'quoted value: quoted string' => [
                'valueString' => '"value"',
                'expectedValue' => '"value"',
            ],
            'quoted value: quoted string lacking final quote' => [
                'valueString' => '"value',
                'expectedValue' => '"value"',
            ],
            'quoted value: quoted string with trailing data' => [
                'valueString' => '"value" trailing',
                'expectedValue' => '"value"',
            ],
            'quoted value: quoted string with escaped quotes' => [
                'valueString' => '"\"value\""',
                'expectedValue' => '"\"value\""',
            ],
            'quoted value: quoted string with escaped quotes with trailing data' => [
                'valueString' => '"\"value\"" trailing',
                'expectedValue' => '"\"value\""',
            ],
        ];
    }
}
