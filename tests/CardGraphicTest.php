<?php

namespace App\Tests;

use App\Card\CardGraphic;
use PHPUnit\Framework\TestCase;

class CardGraphicTest extends TestCase
{
    public function testCreateCardGraphic(): void
    {
        $card = new CardGraphic("hearts", "A");

        $this->assertInstanceOf(CardGraphic::class, $card);
        $this->assertSame("hearts", $card->getSuit());
        $this->assertSame("A", $card->getValue());
    }

    public function testGetSuitSymbolForHearts(): void
    {
        $card = new CardGraphic("hearts", "A");

        $this->assertSame("♥", $card->getSuitSymbol());
    }

    public function testGetSuitSymbolForDiamonds(): void
    {
        $card = new CardGraphic("diamonds", "A");

        $this->assertSame("♦", $card->getSuitSymbol());
    }

    public function testGetSuitSymbolForClubs(): void
    {
        $card = new CardGraphic("clubs", "A");

        $this->assertSame("♣", $card->getSuitSymbol());
    }

    public function testGetSuitSymbolForSpades(): void
    {
        $card = new CardGraphic("spades", "A");

        $this->assertSame("♠", $card->getSuitSymbol());
    }

    public function testGetSuitSymbolForInvalidSuit(): void
    {
        $card = new CardGraphic("invalid", "A");

        $this->assertSame("?", $card->getSuitSymbol());
    }

    public function testGetColorForHearts(): void
    {
        $card = new CardGraphic("hearts", "A");

        $this->assertSame("red", $card->getColor());
    }

    public function testGetColorForDiamonds(): void
    {
        $card = new CardGraphic("diamonds", "A");

        $this->assertSame("red", $card->getColor());
    }

    public function testGetColorForClubs(): void
    {
        $card = new CardGraphic("clubs", "A");

        $this->assertSame("black", $card->getColor());
    }

    public function testGetColorForInvalidSuit(): void
    {
        $card = new CardGraphic("invalid", "A");

        $this->assertSame("black", $card->getColor());
    }

    public function testGetAsString(): void
    {
        $card = new CardGraphic("spades", "K");

        $this->assertSame("K♠", $card->getAsString());
    }

    public function testToArray(): void
    {
        $card = new CardGraphic("diamonds", "Q");

        $expected = [
            "suit" => "diamonds",
            "value" => "Q",
            "symbol" => "♦",
            "color" => "red",
            "text" => "Q♦",
        ];

        $this->assertSame($expected, $card->toArray());
    }
}
