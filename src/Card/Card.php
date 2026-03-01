<?php

namespace App\Card;

class Card
{
    protected string $suit;
    protected string $value;

    public function __construct(string $suit, string $value)
    {
        $this->suit = $suit;
        $this->value = $value;
    }

    public function getSuit(): string
    {
        return $this->suit;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getAsString(): string
    {
        return sprintf("%s of %s", $this->value, $this->suit);
    }

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

    public function toArray(): array
    {
        return [
            "suit" => $this->suit,
            "value" => $this->value,
            "text" => $this->getAsString(),
        ];
    }
}