<?php

namespace App\Card;

/**
 * Represents a playing card.
 */
class Card
{
    /**
     * Card suit.
     */
    protected string $suit;

    /**
     * Card value.
     */
    protected string $value;

    /**
     * Create a card.
     */
    public function __construct(string $suit, string $value)
    {
        $this->suit = $suit;
        $this->value = $value;
    }

    /**
     * Get suit.
     */
    public function getSuit(): string
    {
        return $this->suit;
    }

    /**
     * Get value.
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * Get card as string.
     */
    public function getAsString(): string
    {
        return sprintf("%s of %s", $this->value, $this->suit);
    }

    /**
     * Get suit order.
     */
    public function getSuitOrder(): int
    {
        return match ($this->suit) {
            "clubs" => 1,
            "diamonds" => 2,
            "hearts" => 3,
            "spades" => 4,
            default => 99,
        };
    }

    /**
     * Get value order.
     */
    public function getValueOrder(): int
    {
        return match ($this->value) {
            "A" => 1,
            "2" => 2,
            "3" => 3,
            "4" => 4,
            "5" => 5,
            "6" => 6,
            "7" => 7,
            "8" => 8,
            "9" => 9,
            "10" => 10,
            "J" => 11,
            "Q" => 12,
            "K" => 13,
            default => 99,
        };
    }

    /**
     * Convert to array.
     */
    public function toArray(): array
    {
        return [
            "suit" => $this->suit,
            "value" => $this->value,
            "text" => $this->getAsString(),
        ];
    }
}