<?php

declare(strict_types=1);

namespace webignition\BasilValueExtractor\Tests\Unit;

use webignition\BasilValueExtractor\IdentifierExtractor;
use webignition\BasilValueExtractor\Tests\DataProvider\DescendantIdentifierDataProviderTrait;
use webignition\BasilValueExtractor\Tests\DataProvider\ElementIdentifierDataProviderTrait;
use webignition\BasilValueExtractor\Tests\DataProvider\VariableValueDataProviderTrait;

class IdentifierExtractorTest extends \PHPUnit\Framework\TestCase
{
    use DescendantIdentifierDataProviderTrait;
    use ElementIdentifierDataProviderTrait;
    use VariableValueDataProviderTrait;

    private IdentifierExtractor $extractor;

    protected function setUp(): void
    {
        parent::setUp();

        $this->extractor = IdentifierExtractor::createExtractor();
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
            'quoted value' => [
                'string' => '"quoted"',
            ],
        ];
    }

    /**
     * @dataProvider descendantIdentifierDataProvider
     * @dataProvider elementIdentifierDataProvider
     * @dataProvider variableValueDataProvider
     */
    public function testExtractReturnsString(string $valueString, string $expectedValue)
    {
        $identifierString = $this->extractor->extract($valueString);

        $this->assertSame($expectedValue, $identifierString);
    }
}
