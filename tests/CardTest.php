<?php

namespace App\Tests\Card;

use App\Card\Card;
use PHPUnit\Framework\TestCase;

class CardTest extends TestCase
{
    public function testCreateCardAndGetters(): void
    {
        $card = new Card("hearts", "A");

        $this->assertInstanceOf(Card::class, $card);
        $this->assertSame("hearts", $card->getSuit());
        $this->assertSame("A", $card->getValue());
    }

    public function testGetAsString(): void
    {
        $card = new Card("spades", "K");

        $this->assertSame("K of spades", $card->getAsString());
    }

    public function testGetSuitOrderForClubs(): void
    {
        $card = new Card("clubs", "7");

        $this->assertSame(1, $card->getSuitOrder());
    }

    public function testGetSuitOrderForDiamonds(): void
    {
        $card = new Card("diamonds", "7");

        $this->assertSame(2, $card->getSuitOrder());
    }

    public function testGetSuitOrderForHearts(): void
    {
        $card = new Card("hearts", "7");

        $this->assertSame(3, $card->getSuitOrder());
    }

    public function testGetSuitOrderForSpades(): void
    {
        $card = new Card("spades", "7");

        $this->assertSame(4, $card->getSuitOrder());
    }

    public function testGetSuitOrderForInvalidSuit(): void
    {
        $card = new Card("invalid", "7");

        $this->assertSame(99, $card->getSuitOrder());
    }

    public function testGetValueOrderForAce(): void
    {
        $card = new Card("hearts", "A");

        $this->assertSame(1, $card->getValueOrder());
    }

    public function testGetValueOrderForNumberCard(): void
    {
        $card = new Card("hearts", "10");

        $this->assertSame(10, $card->getValueOrder());
    }

    public function testGetValueOrderForJack(): void
    {
        $card = new Card("hearts", "J");

        $this->assertSame(11, $card->getValueOrder());
    }

    public function testGetValueOrderForQueen(): void
    {
        $card = new Card("hearts", "Q");

        $this->assertSame(12, $card->getValueOrder());
    }

    public function testGetValueOrderForKing(): void
    {
        $card = new Card("hearts", "K");

        $this->assertSame(13, $card->getValueOrder());
    }

    public function testGetValueOrderForInvalidValue(): void
    {
        $card = new Card("hearts", "invalid");

        $this->assertSame(99, $card->getValueOrder());
    }

    public function testToArray(): void
    {
        $card = new Card("diamonds", "Q");

        $expected = [
            "suit" => "diamonds",
            "value" => "Q",
            "text" => "Q of diamonds",
        ];

        $this->assertSame($expected, $card->toArray());
    }
}