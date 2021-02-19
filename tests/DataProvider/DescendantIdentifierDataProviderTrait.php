<?php

declare(strict_types=1);

namespace webignition\BasilValueExtractor\Tests\DataProvider;

trait DescendantIdentifierDataProviderTrait
{
    /**
     * @return array[]
     */
    public function descendantIdentifierDataProvider(): array
    {
        $dataSets = [
            'parent >> child' => [
                'valueString' => '$".parent" >> $".child"',
                'expectedValue' => '$".parent" >> $".child"',
            ],
            'parent >> child:position' => [
                'valueString' => '$".parent" >> $".child":3',
                'expectedValue' => '$".parent" >> $".child":3',
            ],
            'parent >> child.attribute' => [
                'valueString' => '$".parent" >> $".child".attribute_name',
                'expectedValue' => '$".parent" >> $".child".attribute_name',
            ],
            'parent >> child:position.attribute' => [
                'valueString' => '$".parent" >> $".child":5.attribute_name',
                'expectedValue' => '$".parent" >> $".child":5.attribute_name',
            ],
            'grandparent >> parent >> child' => [
                'valueString' => '$".grandparent" >> $".parent" >> $".child"',
                'expectedValue' => '$".grandparent" >> $".parent" >> $".child"',
            ],
            'great-grandparent >> grandparent >> parent >> child' => [
                'valueString' => '$".great-grandparent" >> $".grandparent >> $".parent" >> $".child"',
                'expectedValue' => '$".great-grandparent" >> $".grandparent >> $".parent" >> $".child"',
            ],
            'parent >> child, page element reference' => [
                'valueString' => '$parent >> $".child"',
                'expectedValue' => '$parent >> $".child"',
            ],
        ];

        foreach ($dataSets as $name => $data) {
            $additionalDataName = $name . ' with additional non-relevant data';
            $data['valueString'] .= ' additional non-relevant data';

            $dataSets[$additionalDataName] = $data;
        }

        return $dataSets;
    }
}
