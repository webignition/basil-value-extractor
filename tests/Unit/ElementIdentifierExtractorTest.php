<?php

declare(strict_types=1);

namespace webignition\BasilValueExtractor\Tests\Unit;

use webignition\BasilValueExtractor\ElementIdentifierExtractor;
use webignition\BasilValueExtractor\Tests\DataProvider\ElementIdentifierDataProviderTrait;

class ElementIdentifierExtractorTest extends \PHPUnit\Framework\TestCase
{
    use ElementIdentifierDataProviderTrait;

    /**
     * @var ElementIdentifierExtractor
     */
    private $extractor;

    protected function setUp(): void
    {
        parent::setUp();

        $this->extractor = new ElementIdentifierExtractor();
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
            'not internally quoted' => [
                'string' => '$value',
            ],
        ];
    }

    /**
     * @dataProvider elementIdentifierDataProvider
     */
    public function testExtractReturnsString(string $valueString, string $expectedValue)
    {
        $identifierString = $this->extractor->extract($valueString);

        $this->assertSame($expectedValue, $identifierString);
    }
}
