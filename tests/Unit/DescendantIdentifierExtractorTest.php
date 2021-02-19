<?php

declare(strict_types=1);

namespace webignition\BasilValueExtractor\Tests\Unit;

use webignition\BasilValueExtractor\DescendantIdentifierExtractor;
use webignition\BasilValueExtractor\Tests\DataProvider\DescendantIdentifierDataProviderTrait;

class DescendantIdentifierExtractorTest extends \PHPUnit\Framework\TestCase
{
    use DescendantIdentifierDataProviderTrait;

    private DescendantIdentifierExtractor $extractor;

    protected function setUp(): void
    {
        parent::setUp();

        $this->extractor = DescendantIdentifierExtractor::createExtractor();
    }

    /**
     * @dataProvider returnsEmptyValueDataProvider
     */
    public function testExtractIdentifierReturnsEmptyValue(string $string): void
    {
        $this->assertNull($this->extractor->extractIdentifier($string));
    }

    /**
     * @return array[]
     */
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
     * @dataProvider descendantIdentifierDataProvider
     * @dataProvider extractIdentifierReturnsStringDataProvider
     */
    public function testExtractIdentifierReturnsString(string $valueString, string $expectedValue): void
    {
        $identifierString = $this->extractor->extractIdentifier($valueString);

        $this->assertSame($expectedValue, $identifierString);
    }

    /**
     * @return array[]
     */
    public function extractIdentifierReturnsStringDataProvider(): array
    {
        return [
            'variable parameter: page-level element, within reference' => [
                'valueString' => '$form >> $".selector"',
                'expectedValue' => '$form >> $".selector"',
            ],
        ];
    }

    /**
     * @dataProvider extractParentIdentifierReturnsEmptyValueDataProvider
     */
    public function testExtractParentIdentifierReturnsEmptyValue(string $string): void
    {
        $this->assertNull($this->extractor->extractParentIdentifier($string));
    }

    /**
     * @return array[]
     */
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
    public function testExtractParentIdentifierReturnsString(string $string, string $expectedParentIdentifier): void
    {
        $identifierString = $this->extractor->extractParentIdentifier($string);

        $this->assertSame($expectedParentIdentifier, $identifierString);
    }

    /**
     * @return array[]
     */
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
            'parent >> child, page element reference' => [
                'valueString' => '$parent >> $".child"',
                'expectedValue' => '$parent',
            ],
        ];
    }

    /**
     * @dataProvider extractChildIdentifierReturnsEmptyValueDataProvider
     */
    public function testExtractChildIdentifierReturnsEmptyValue(string $string): void
    {
        $this->assertNull($this->extractor->extractChildIdentifier($string));
    }

    /**
     * @return array[]
     */
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
    public function testExtractChildIdentifierReturnsString(string $string, string $expectedChildIdentifier): void
    {
        $identifierString = $this->extractor->extractChildIdentifier($string);

        $this->assertSame($expectedChildIdentifier, $identifierString);
    }

    /**
     * @return array[]
     */
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
            'parent >> child, page element reference' => [
                'valueString' => '$parent >> $".child"',
                'expectedValue' => '$".child"',
            ],
        ];
    }
}
