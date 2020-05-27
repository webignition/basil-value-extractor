<?php

declare(strict_types=1);

namespace webignition\BasilValueExtractor\Tests\Unit;

use webignition\BasilValueExtractor\Tests\DataProvider\DescendantIdentifierDataProviderTrait;
use webignition\BasilValueExtractor\Tests\DataProvider\ElementIdentifierDataProviderTrait;
use webignition\BasilValueExtractor\Tests\DataProvider\QuotedValueDataProviderTrait;
use webignition\BasilValueExtractor\Tests\DataProvider\VariableValueDataProviderTrait;
use webignition\BasilValueExtractor\ValueExtractor;

class ValueExtractorTest extends \PHPUnit\Framework\TestCase
{
    use DescendantIdentifierDataProviderTrait;
    use ElementIdentifierDataProviderTrait;
    use VariableValueDataProviderTrait;
    use QuotedValueDataProviderTrait;

    private ValueExtractor $extractor;

    protected function setUp(): void
    {
        parent::setUp();

        $this->extractor = ValueExtractor::createExtractor();
    }

    /**
     * @dataProvider returnsEmptyValueDataProvider
     */
    public function testExtractReturnsEmptyValue(string $string)
    {
        $this->assertNull($this->extractor->extract($string));
    }

    public function returnsEmptyValueDataProvider(): array
    {
        return [
            'empty' => [
                'string' => '',
            ],
        ];
    }

    /**
     * @dataProvider descendantIdentifierDataProvider
     * @dataProvider elementIdentifierDataProvider
     * @dataProvider variableValueDataProvider
     * @dataProvider quotedValueDataProvider
     */
    public function testExtractReturnsString(string $valueString, string $expectedValue)
    {
        $identifierString = $this->extractor->extract($valueString);

        $this->assertSame($expectedValue, $identifierString);
    }
}
