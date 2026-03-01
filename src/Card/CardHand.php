<?php

namespace App\Card;

class CardHand
{
    /** @var Card[] */
    private array $cards = [];

    public function add(Card $card): void
    {
        $this->cards[] = $card;
    }

    /**
     * @return Card[]
     */
    public function getCards(): array
    {
        return $this->cards;
    }

    public function count(): int
    {
        return count($this->cards);
    }

    public function toArray(): array
    {
        return array_map(fn (Card $c) => $c->toArray(), $this->cards);
    }
}