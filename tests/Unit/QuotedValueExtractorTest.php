<?php

declare(strict_types=1);

namespace webignition\BasilValueExtractor\Tests\Unit;

use phpmock\mockery\PHPMockery;
use webignition\BasilValueExtractor\QuotedValueExtractor;
use webignition\BasilValueExtractor\Tests\DataProvider\QuotedValueDataProviderTrait;

class QuotedValueExtractorTest extends \PHPUnit\Framework\TestCase
{
    use QuotedValueDataProviderTrait;

    private QuotedValueExtractor $extractor;

    protected function setUp(): void
    {
        parent::setUp();

        $this->extractor = QuotedValueExtractor::createExtractor();
    }

    /**
     * @dataProvider extractReturnsNullDataProvider
     */
    public function testExtractReturnsNull(string $valueString): void
    {
        $this->assertNull($this->extractor->extract($valueString));
    }

    /**
     * @return array<mixed>
     */
    public function extractReturnsNullDataProvider(): array
    {
        return [
            'empty' => [
                'valueString' => '',
            ],
            'unquoted' => [
                'valueString' => 'value',
            ],
        ];
    }

    public function testExtractReturnsEmptyValueForNonSplittableString(): void
    {
        $valueString = '"causes preg_split to fail"';

        PHPMockery::mock('webignition\BasilValueExtractor', 'preg_split')->andReturnFalse();

        $this->assertEquals('""', $this->extractor->extract($valueString));

        \Mockery::close();
    }

    /**
     * @dataProvider quotedValueDataProvider
     */
    public function testExtractReturnsString(string $valueString, string $expectedValue): void
    {
        $value = $this->extractor->extract($valueString);

        $this->assertSame($expectedValue, $value);
    }
}
