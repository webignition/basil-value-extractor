<?php

declare(strict_types=1);

namespace webignition\BasilValueExtractor\Tests\DataProvider;

trait VariableValueDataProviderTrait
{
    public function variableValueDataProvider(): array
    {
        return [
            'variable parameter: assertion: page parameter is value' => [
                'valueString' => '$page.title is "value"',
                'expectedValue' => '$page.title',
            ],
            'variable parameter: assertion: element parameter is value' => [
                'valueString' => '$elements.name is "value"',
                'expectedValue' => '$elements.name',
            ],
            'variable parameter: page parameter only' => [
                'valueString' => '$page.title',
                'expectedValue' => '$page.title',
            ],
            'variable parameter: page parameter is environment value' => [
                'valueString' => '$page.title is $env.KEY',
                'expectedValue' => '$page.title',
            ],
            'variable parameter: page parameter is environment value with default' => [
                'valueString' => '$page.title is $env.KEY|"default"',
                'expectedValue' => '$page.title',
            ],
            'variable parameter: assertion: environment parameter is value' => [
                'valueString' => '$env.KEY is "value"',
                'expectedValue' => '$env.KEY',
            ],
            'variable parameter: assertion: environment parameter with default without whitespace is value' => [
                'valueString' => '$env.KEY|"default" is "value"',
                'expectedValue' => '$env.KEY|"default"',
            ],
            'variable parameter: assertion: environment parameter with default with whitespace is value' => [
                'valueString' => '$env.KEY|"default value" is "value"',
                'expectedValue' => '$env.KEY|"default value"',
            ],
            'variable parameter: data parameter' => [
                'valueString' => '$data.data_name',
                'expectedValue' => '$data.data_name',
            ],
            'variable parameter: data parameter with trailing data' => [
                'valueString' => '$data.data_name trailing',
                'expectedValue' => '$data.data_name',
            ],
            'variable parameter: data parameter with default' => [
                'valueString' => '$data.data_name|"default"',
                'expectedValue' => '$data.data_name|"default"',
            ],
            'variable parameter: data parameter with default with trailing data' => [
                'valueString' => '$data.data_name|"default" trailing',
                'expectedValue' => '$data.data_name|"default"',
            ],
            'variable parameter: assertion, page model reference is value' => [
                'valueString' => '$page.elements.name is "value"',
                'expectedValue' => '$page.elements.name',
            ],
            'variable parameter: assertion, page model reference only' => [
                'valueString' => '$page.elements.name',
                'expectedValue' => '$page.elements.name',
            ],
            'variable parameter: page-level element, reference only' => [
                'valueString' => '$form',
                'expectedValue' => '$form',
            ],
        ];
    }
}
