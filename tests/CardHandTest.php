<?php

namespace App\Tests;

use App\Card\Card;
use App\Card\CardHand;
use PHPUnit\Framework\TestCase;

class CardHandTest extends TestCase
{
    public function testCreateEmptyHand(): void
    {
        $hand = new CardHand();

        $this->assertInstanceOf(CardHand::class, $hand);
        $this->assertSame([], $hand->getCards());
        $this->assertSame(0, $hand->count());
        $this->assertSame([], $hand->toArray());
    }

    public function testAddOneCard(): void
    {
        $hand = new CardHand();
        $card = new Card("hearts", "A");

        $hand->add($card);

        $cards = $hand->getCards();

        $this->assertCount(1, $cards);
        $this->assertSame(1, $hand->count());
        $this->assertInstanceOf(Card::class, $cards[0]);
        $this->assertSame("hearts", $cards[0]->getSuit());
        $this->assertSame("A", $cards[0]->getValue());
    }

    public function testAddMultipleCards(): void
    {
        $hand = new CardHand();

        $card1 = new Card("hearts", "A");
        $card2 = new Card("spades", "K");

        $hand->add($card1);
        $hand->add($card2);

        $cards = $hand->getCards();

        $this->assertCount(2, $cards);
        $this->assertSame(2, $hand->count());
        $this->assertSame($card1, $cards[0]);
        $this->assertSame($card2, $cards[1]);
    }

    public function testToArrayWithCards(): void
    {
        $hand = new CardHand();

        $hand->add(new Card("hearts", "A"));
        $hand->add(new Card("diamonds", "Q"));

        $expected = [
            [
                "suit" => "hearts",
                "value" => "A",
                "text" => "A of hearts",
            ],
            [
                "suit" => "diamonds",
                "value" => "Q",
                "text" => "Q of diamonds",
            ],
        ];

        $this->assertSame($expected, $hand->toArray());
    }
}
