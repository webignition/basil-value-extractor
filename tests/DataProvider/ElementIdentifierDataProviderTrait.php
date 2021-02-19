<?php

declare(strict_types=1);

namespace webignition\BasilValueExtractor\Tests\DataProvider;

trait ElementIdentifierDataProviderTrait
{
    /**
     * @return array[]
     */
    public function elementIdentifierDataProvider(): array
    {
        $dataSets = [
            'identifier only' => [
                'valueString' => '$".selector"',
                'expectedValue' => '$".selector"',
            ],
            'positive integer position' => [
                'valueString' => '$".selector":1',
                'expectedValue' => '$".selector":1',
            ],
            'negative integer position' => [
                'valueString' => '$".selector":-1',
                'expectedValue' => '$".selector":-1',
            ],
            'first position' => [
                'valueString' => '$".selector":first',
                'expectedValue' => '$".selector":first',
            ],
            'last position' => [
                'valueString' => '$".selector":last',
                'expectedValue' => '$".selector":last',
            ],
            'with attribute name' => [
                'valueString' => '$".selector".attribute_name',
                'expectedValue' => '$".selector".attribute_name',
            ],
            ' positive integer position, attribute name' => [
                'valueString' => '$".selector":1.attribute_name',
                'expectedValue' => '$".selector":1.attribute_name',
            ],
            'negative integer position, attribute name' => [
                'valueString' => '$".selector":-1.attribute_name',
                'expectedValue' => '$".selector":-1.attribute_name',
            ],
            'first position, attribute name' => [
                'valueString' => '$".selector":first.attribute_name',
                'expectedValue' => '$".selector":first.attribute_name',
            ],
            'last position, attribute name' => [
                'valueString' => '$".selector":last.attribute_name',
                'expectedValue' => '$".selector":last.attribute_name',
            ],
            'encapsulated by escaped quotes' => [
                'valueString' => '$"\".selector\""',
                'expectedValue' => '$"\".selector\""',
            ],
            'containing escaped quotes' => [
                'valueString' => '$".selector \".is\""',
                'expectedValue' => '$".selector \".is\""',
            ],
            'position delimiter without position' => [
                'valueString' => '$".selector":',
                'expectedValue' => '$".selector"',
            ],
            'attribute delimiter without attribute' => [
                'valueString' => '$".selector".',
                'expectedValue' => '$".selector"',
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
