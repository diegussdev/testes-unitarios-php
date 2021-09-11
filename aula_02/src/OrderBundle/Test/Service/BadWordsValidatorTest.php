<?php

namespace OrderBundle\Service\Test;

use OrderBundle\Repository\BadWordsRepository;
use OrderBundle\Service\BadWordsValidator;
use PHPUnit\Framework\TestCase;

class BadWordsValidatorTest extends TestCase
{
    /**
     * @test
     * @dataProvider valueProvider
     */
    public function testIsValid($basWordsList, $text, $foundBadWords)
    {
        $badWordsRepository = $this->createMock(BadWordsRepository::class);
        $badWordsRepository->method('findAllAsArray')
            ->willReturn($basWordsList);
        $badWordsValidator = new BadWordsValidator($badWordsRepository);

        $hasBadWords = $badWordsValidator->hasBadWords($text);

        $this->assertEquals($foundBadWords, $hasBadWords);

    }

    public function valueProvider()
    {
        return [
            'shouldFindWhenHasBadWords' => [
                'badWordsList' => ['bobo', 'chulé', 'besta'],
                'text' => 'Seu restaurante é muito bobo',
                'foundBadWords' => true,
            ],
            'shouldNotFindWhenHasNoBadWords' => [
                'badWordsList' => ['bobo', 'chulé', 'besta'],
                'text' => 'Trocar batata por salada',
                'foundBadWords' => false,
            ],
            'shouldNotFindWhenTextIsEmpty' => [
                'badWordsList' => ['bobo', 'chulé', 'besta'],
                'text' => '',
                'foundBadWords' => false,
            ],
            'shouldNotFindWhenBadWordsListIsEmpty' => [
                'badWordsList' => [],
                'text' => 'Seu restaurante é muito bobo',
                'foundBadWords' => false,
            ],
        ];
    }
}
