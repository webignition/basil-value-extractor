<?php

declare(strict_types=1);

namespace webignition\BasilValueExtractor\Tests\Unit;

use webignition\BasilValueExtractor\Tests\DataProvider\VariableValueDataProviderTrait;
use webignition\BasilValueExtractor\VariableValueExtractor;

class VariableValueExtractorTest extends \PHPUnit\Framework\TestCase
{
    use VariableValueDataProviderTrait;

    private VariableValueExtractor $extractor;

    protected function setUp(): void
    {
        parent::setUp();

        $this->extractor = VariableValueExtractor::createExtractor();
    }

    /**
     * @dataProvider unhandledStringsDataProvider
     */
    public function testExtractReturnsEmptyValue(string $string): void
    {
        $this->assertNull($this->extractor->extract($string));
    }

    /**
     * @return array<mixed>
     */
    public function unhandledStringsDataProvider(): array
    {
        return [
            'empty' => [
                'string' => '',
            ],
            'quoted value' => [
                'string' => '"quoted"',
            ],
        ];
    }

    /**
     * @dataProvider variableValueDataProvider
     * @dataProvider extractReturnsStringDataProvider
     */
    public function testExtractReturnsString(string $valueString, string $expectedValue): void
    {
        $identifierString = $this->extractor->extract($valueString);

        $this->assertSame($expectedValue, $identifierString);
    }

    /**
     * @return array<mixed>
     */
    public function extractReturnsStringDataProvider(): array
    {
        return [
            'variable parameter: page-level element, within reference' => [
                'valueString' => '$form >> $".selector"',
                'expectedValue' => '$form',
            ],
        ];
    }
}
