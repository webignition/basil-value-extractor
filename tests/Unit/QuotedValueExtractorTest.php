<?php

namespace webignition\BasilValueExtractor\Tests\Unit;

use phpmock\mockery\PHPMockery;
use webignition\BasilValueExtractor\QuotedValueExtractor;
use webignition\BasilValueExtractor\Tests\DataProvider\QuotedValueDataProviderTrait;

class QuotedValueExtractorTest extends \PHPUnit\Framework\TestCase
{
    use QuotedValueDataProviderTrait;

    /**
     * @var QuotedValueExtractor
     */
    private $quotedValueExtractor;

    protected function setUp(): void
    {
        parent::setUp();

        $this->quotedValueExtractor = new QuotedValueExtractor();
    }

    /**
     * @dataProvider extractReturnsNullDataProvider
     */
    public function testExtractReturnsNull(string $valueString)
    {
        $this->assertNull($this->quotedValueExtractor->extract($valueString));
    }

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

    public function testExtractReturnsEmptyValueForNonSplittableString()
    {
        $valueString = '"causes preg_split to fail"';

        PHPMockery::mock('webignition\BasilValueExtractor', 'preg_split')->andReturnFalse();

        $this->assertEquals('""', $this->quotedValueExtractor->extract($valueString));

        \Mockery::close();
    }

    /**
     * @dataProvider quotedValueDataProvider
     */
    public function testExtractReturnsString(string $valueString, string $expectedValue)
    {
        $value = $this->quotedValueExtractor->extract($valueString);

        $this->assertSame($expectedValue, $value);
    }
}
