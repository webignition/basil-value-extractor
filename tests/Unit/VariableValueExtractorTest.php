<?php

declare(strict_types=1);

namespace webignition\BasilValueExtractor\Tests\Unit;

use webignition\BasilValueExtractor\Tests\DataProvider\VariableValueDataProviderTrait;
use webignition\BasilValueExtractor\VariableValueExtractor;

class VariableValueExtractorTest extends \PHPUnit\Framework\TestCase
{
    use VariableValueDataProviderTrait;

    /**
     * @var VariableValueExtractor
     */
    private $extractor;

    protected function setUp(): void
    {
        parent::setUp();

        $this->extractor = new VariableValueExtractor();
    }

    /**
     * @dataProvider unhandledStringsDataProvider
     */
    public function testExtractReturnsEmptyValue(string $string)
    {
        $this->assertNull($this->extractor->extract($string));
    }

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
    public function testExtractReturnsString(string $valueString, string $expectedValue)
    {
        $identifierString = $this->extractor->extract($valueString);

        $this->assertSame($expectedValue, $identifierString);
    }

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
