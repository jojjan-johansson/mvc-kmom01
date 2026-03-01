<?php

namespace App\Card;

class DeckOfCards
{
    /** @var Card[] */
    private array $cards = [];

    public function __construct()
    {
        $this->cards = $this->createOrderedDeck();
    }

    /**
     * @return Card[]
     */
    private function createOrderedDeck(): array
    {
        $suits = ["clubs", "diamonds", "hearts", "spades"];
        $values = ["A","2","3","4","5","6","7","8","9","10","J","Q","K"];

        $deck = [];
        foreach ($suits as $suit) {
            foreach ($values as $value) {
                $deck[] = new CardGraphic($suit, $value);
            }
        }

        usort($deck, function (Card $a, Card $b) {
            if ($a->getSuitOrder() === $b->getSuitOrder()) {
                return $a->getValueOrder() <=> $b->getValueOrder();
            }
            return $a->getSuitOrder() <=> $b->getSuitOrder();
        });

        return $deck;
    }

    public function shuffle(): void
    {
        shuffle($this->cards);
    }

    public function count(): int
    {
        return count($this->cards);
    }

    /**
     * @return Card[]
     */
    public function draw(int $number = 1): array
    {
        $number = max(0, $number);
        $drawn = [];

        for ($i = 0; $i < $number; $i++) {
            if (empty($this->cards)) {
                break;
            }
            $drawn[] = array_shift($this->cards);
        }

        return $drawn;
    }

    /**
     * @return Card[]
     */
    public function getCards(): array
    {
        return $this->cards;
    }

    public function toArray(): array
    {
        return array_map(fn (Card $c) => $c->toArray(), $this->cards);
    }
}