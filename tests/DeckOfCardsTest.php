<?php

namespace App\Tests;

use App\Card\Card;
use App\Card\CardGraphic;
use App\Card\DeckOfCards;
use PHPUnit\Framework\TestCase;

class DeckOfCardsTest extends TestCase
{
    public function testCreateDeck(): void
    {
        $deck = new DeckOfCards();

        $this->assertInstanceOf(DeckOfCards::class, $deck);
        $this->assertSame(52, $deck->count());
    }

    public function testGetCardsReturnsFullDeck(): void
    {
        $deck = new DeckOfCards();
        $cards = $deck->getCards();

        $this->assertCount(52, $cards);
        $this->assertInstanceOf(Card::class, $cards[0]);
        $this->assertInstanceOf(CardGraphic::class, $cards[0]);
    }

    public function testOrderedDeckStartsWithAceOfClubs(): void
    {
        $deck = new DeckOfCards();
        $cards = $deck->getCards();

        $this->assertSame("A♣", $cards[0]->getAsString());
    }

    public function testOrderedDeckEndsWithKingOfSpades(): void
    {
        $deck = new DeckOfCards();
        $cards = $deck->getCards();

        $this->assertSame("K♠", $cards[51]->getAsString());
    }

    public function testShuffleKeepsCardCount(): void
    {
        $deck = new DeckOfCards();

        $deck->shuffle();

        $this->assertSame(52, $deck->count());
        $this->assertCount(52, $deck->getCards());
    }

    public function testDrawOneCard(): void
    {
        $deck = new DeckOfCards();

        $drawn = $deck->draw();

        $this->assertCount(1, $drawn);
        $this->assertInstanceOf(Card::class, $drawn[0]);
        $this->assertSame(51, $deck->count());
    }

    public function testDrawMultipleCards(): void
    {
        $deck = new DeckOfCards();

        $drawn = $deck->draw(5);

        $this->assertCount(5, $drawn);
        $this->assertSame(47, $deck->count());
    }

    public function testDrawZeroCards(): void
    {
        $deck = new DeckOfCards();

        $drawn = $deck->draw(0);

        $this->assertSame([], $drawn);
        $this->assertSame(52, $deck->count());
    }

    public function testDrawNegativeNumberReturnsEmptyArray(): void
    {
        $deck = new DeckOfCards();

        $drawn = $deck->draw(-5);

        $this->assertSame([], $drawn);
        $this->assertSame(52, $deck->count());
    }

    public function testDrawMoreCardsThanAvailable(): void
    {
        $deck = new DeckOfCards();

        $drawn = $deck->draw(60);

        $this->assertCount(52, $drawn);
        $this->assertSame(0, $deck->count());
    }

    public function testDrawFromEmptyDeck(): void
    {
        $deck = new DeckOfCards();

        $deck->draw(52);
        $drawn = $deck->draw(1);

        $this->assertSame([], $drawn);
        $this->assertSame(0, $deck->count());
    }

    public function testToArrayReturnsArrayRepresentation(): void
    {
        $deck = new DeckOfCards();

        $array = $deck->toArray();

        $this->assertCount(52, $array);
        $this->assertSame(
            [
                "suit" => "clubs",
                "value" => "A",
                "symbol" => "♣",
                "color" => "black",
                "text" => "A♣",
            ],
            $array[0]
        );
    }

    public function testToArrayAfterDraw(): void
    {
        $deck = new DeckOfCards();

        $deck->draw(2);
        $array = $deck->toArray();

        $this->assertCount(50, $array);
        $this->assertSame("3", $array[0]["value"]);
        $this->assertSame("clubs", $array[0]["suit"]);
    }
}