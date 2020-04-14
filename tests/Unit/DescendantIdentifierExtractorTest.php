<?php

declare(strict_types=1);

namespace webignition\BasilValueExtractor\Tests\Unit;

use webignition\BasilValueExtractor\DescendantIdentifierExtractor;
use webignition\BasilValueExtractor\ElementIdentifierExtractor;

class DescendantIdentifierExtractorTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var DescendantIdentifierExtractor
     */
    private $extractor;

    protected function setUp(): void
    {
        parent::setUp();

        $this->extractor = new DescendantIdentifierExtractor(
            new ElementIdentifierExtractor()
        );
    }

    /**
     * @dataProvider returnsEmptyValueDataProvider
     */
    public function testExtractIdentifierReturnsEmptyValue(string $string)
    {
        $this->assertNull($this->extractor->extractIdentifier($string));
    }

    public function returnsEmptyValueDataProvider(): array
    {
        return [
            'empty' => [
                'string' => '',
            ],
            'variable value' => [
                'string' => '$elements.element_name',
            ],
            'invalid parent identifier' => [
                'string' => '$".parent >> $".child"',
            ],
            'invalid child identifier' => [
                'string' => '$".parent" >> ".child"',
            ],
            'statement with non-descendant identifier' => [
                'string' => '$".selector" is "value"',
            ],
        ];
    }

    /**
     * @dataProvider descendantIdentifierStringDataProvider
     */
    public function testExtractIdentifierReturnsString(string $string, string $expectedIdentifierString)
    {
        $identifierString = $this->extractor->extractIdentifier($string);

        $this->assertSame($expectedIdentifierString, $identifierString);
    }

    public function descendantIdentifierStringDataProvider(): array
    {
        $dataSets = [
            'parent >> child' => [
                'string' => '$".parent" >> $".child"',
                'expectedIdentifierString' => '$".parent" >> $".child"',
            ],
            'parent >> child:position' => [
                'string' => '$".parent" >> $".child":3',
                'expectedIdentifierString' => '$".parent" >> $".child":3',
            ],
            'parent >> child.attribute' => [
                'string' => '$".parent" >> $".child".attribute_name',
                'expectedIdentifierString' => '$".parent" >> $".child".attribute_name',
            ],
            'parent >> child:position.attribute' => [
                'string' => '$".parent" >> $".child":5.attribute_name',
                'expectedIdentifierString' => '$".parent" >> $".child":5.attribute_name',
            ],
            'grandparent >> parent >> child' => [
                'string' => '$".grandparent" >> $".parent" >> $".child"',
                'expectedIdentifierString' => '$".grandparent" >> $".parent" >> $".child"',
            ],
            'great-grandparent >> grandparent >> parent >> child' => [
                'string' => '$".great-grandparent" >> $".grandparent >> $".parent" >> $".child"',
                'expectedIdentifierString' => '$".great-grandparent" >> $".grandparent >> $".parent" >> $".child"',
            ],
        ];

        foreach ($dataSets as $name => $data) {
            $additionalDataName = $name . ' with additional non-relevant data';
            $data['string'] .= ' additional non-relevant data';

            $dataSets[$additionalDataName] = $data;
        }

        return $dataSets;
    }

    /**
     * @dataProvider extractParentIdentifierReturnsEmptyValueDataProvider
     */
    public function testExtractParentIdentifierReturnsEmptyValue(string $string)
    {
        $this->assertNull($this->extractor->extractParentIdentifier($string));
    }

    public function extractParentIdentifierReturnsEmptyValueDataProvider(): array
    {
        return [
            'empty' => [
                'string' => '',
            ],
            'variable value' => [
                'string' => '$elements.element_name',
            ],
            'invalid parent identifier' => [
                'string' => '$".parent >> $".child"',
            ],
            'statement with non-descendant identifier' => [
                'string' => '$".selector" is "value"',
            ],
        ];
    }

    /**
     * @dataProvider extractParentIdentifierDataProvider
     */
    public function testExtractParentIdentifierReturnsString(string $string, string $expectedParentIdentifier)
    {
        $identifierString = $this->extractor->extractParentIdentifier($string);

        $this->assertSame($expectedParentIdentifier, $identifierString);
    }

    public function extractParentIdentifierDataProvider(): array
    {
        return [
            'parent >> child' => [
                'string' => '$".parent" >> $".child"',
                'expectedIdentifierString' => '$".parent"',
            ],
            'parent >> child:position' => [
                'string' => '$".parent" >> $".child":3',
                'expectedIdentifierString' => '$".parent"',
            ],
            'parent >> child.attribute' => [
                'string' => '$".parent" >> $".child".attribute_name',
                'expectedIdentifierString' => '$".parent"',
            ],
            'parent >> child:position.attribute' => [
                'string' => '$".parent" >> $".child":5.attribute_name',
                'expectedIdentifierString' => '$".parent"',
            ],
            'grandparent >> parent >> child' => [
                'string' => '$".grandparent" >> $".parent" >> $".child"',
                'expectedIdentifierString' => '$".grandparent" >> $".parent"',
            ],
            'great-grandparent >> grandparent >> parent >> child' => [
                'string' => '$".great-grandparent" >> $".grandparent >> $".parent" >> $".child"',
                'expectedIdentifierString' => '$".great-grandparent" >> $".grandparent >> $".parent"',
            ],
        ];
    }

    /**
     * @dataProvider extractChildIdentifierReturnsEmptyValueDataProvider
     */
    public function testExtractChildIdentifierReturnsEmptyValue(string $string)
    {
        $this->assertNull($this->extractor->extractChildIdentifier($string));
    }

    public function extractChildIdentifierReturnsEmptyValueDataProvider(): array
    {
        return [
            'empty' => [
                'string' => '',
            ],
            'variable value' => [
                'string' => '$elements.element_name',
            ],
            'invalid parent identifier' => [
                'string' => '$".parent >> $".child"',
            ],
            'invalid child identifier' => [
                'string' => '$".parent" >> ".child"',
            ],
            'statement with non-descendant identifier' => [
                'string' => '$".selector" is "value"',
            ],
        ];
    }

    /**
     * @dataProvider extractChildIdentifierDataProvider
     */
    public function testExtractChildIdentifierReturnsString(string $string, string $expectedChildIdentifier)
    {
        $identifierString = $this->extractor->extractChildIdentifier($string);

        $this->assertSame($expectedChildIdentifier, $identifierString);
    }

    public function extractChildIdentifierDataProvider(): array
    {
        return [
            'parent >> child' => [
                'string' => '$".parent" >> $".child"',
                'expectedIdentifierString' => '$".child"',
            ],
            'parent >> child:position' => [
                'string' => '$".parent" >> $".child":3',
                'expectedIdentifierString' => '$".child":3',
            ],
            'parent >> child.attribute' => [
                'string' => '$".parent" >> $".child".attribute_name',
                'expectedIdentifierString' => '$".child".attribute_name',
            ],
            'parent >> child:position.attribute' => [
                'string' => '$".parent" >> $".child":5.attribute_name',
                'expectedIdentifierString' => '$".child":5.attribute_name',
            ],
            'grandparent >> parent >> child' => [
                'string' => '$".grandparent" >> $".parent" >> $".child"',
                'expectedIdentifierString' => '$".child"',
            ],
            'great-grandparent >> grandparent >> parent >> child' => [
                'string' => '$".great-grandparent" >> $".grandparent >> $".parent" >> $".child"',
                'expectedIdentifierString' => '$".child"',
            ],
        ];
    }
}
