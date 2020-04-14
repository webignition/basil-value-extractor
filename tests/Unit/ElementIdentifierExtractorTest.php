<?php

declare(strict_types=1);

namespace webignition\BasilValueExtractor\Tests\Unit;

use webignition\BasilValueExtractor\ElementIdentifierExtractor;

class ElementIdentifierExtractorTest extends \PHPUnit\Framework\TestCase
{
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
     * @dataProvider identifierStringDataProvider
     */
    public function testExtractReturnsString(string $string, string $expectedIdentifierString)
    {
        $identifierString = $this->extractor->extract($string);

        $this->assertSame($expectedIdentifierString, $identifierString);
    }

    public function identifierStringDataProvider(): array
    {
        $dataSets = [
            'identifier only' => [
                'string' => '$".selector"',
                'expectedIdentifierString' => '$".selector"',
            ],
            'positive integer position' => [
                'string' => '$".selector":1',
                'expectedIdentifierString' => '$".selector":1',
            ],
            'negative integer position' => [
                'string' => '$".selector":-1',
                'expectedIdentifierString' => '$".selector":-1',
            ],
            'first position' => [
                'string' => '$".selector":first',
                'expectedIdentifierString' => '$".selector":first',
            ],
            'last position' => [
                'string' => '$".selector":last',
                'expectedIdentifierString' => '$".selector":last',
            ],
            'with attribute name' => [
                'string' => '$".selector".attribute_name',
                'expectedIdentifierString' => '$".selector".attribute_name',
            ],
            ' positive integer position, attribute name' => [
                'string' => '$".selector":1.attribute_name',
                'expectedIdentifierString' => '$".selector":1.attribute_name',
            ],
            'negative integer position, attribute name' => [
                'string' => '$".selector":-1.attribute_name',
                'expectedIdentifierString' => '$".selector":-1.attribute_name',
            ],
            'first position, attribute name' => [
                'string' => '$".selector":first.attribute_name',
                'expectedIdentifierString' => '$".selector":first.attribute_name',
            ],
            'last position, attribute name' => [
                'string' => '$".selector":last.attribute_name',
                'expectedIdentifierString' => '$".selector":last.attribute_name',
            ],
            'encapsulated by escaped quotes' => [
                'string' => '$"\".selector\""',
                'expectedIdentifierString' => '$"\".selector\""',
            ],
            'containing escaped quotes' => [
                'string' => '$".selector \".is\""',
                'expectedIdentifierString' => '$".selector \".is\""',
            ],
            'position delimiter without position' => [
                'string' => '$".selector":',
                'expectedIdentifierString' => '$".selector"',
            ],
            'attribute delimiter without attribute' => [
                'string' => '$".selector".',
                'expectedIdentifierString' => '$".selector"',
            ],
        ];

        foreach ($dataSets as $name => $data) {
            $additionalDataName = $name . ' with additional non-relevant data';
            $data['string'] .= ' additional non-relevant data';

            $dataSets[$additionalDataName] = $data;
        }

        return $dataSets;
    }
}
