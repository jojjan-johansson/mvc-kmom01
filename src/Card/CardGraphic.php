<?php

namespace App\Card;

class CardGraphic extends Card
{
    public function getSuitSymbol(): string
    {
        return match ($this->suit) {
            "hearts" => "♥",
            "diamonds" => "♦",
            "clubs" => "♣",
            "spades" => "♠",
            default => "?",
        };
    }

    public function getColor(): string
    {
        return match ($this->suit) {
            "hearts", "diamonds" => "red",
            default => "black",
        };
    }

    public function getAsString(): string
    {
        return sprintf("%s%s", $this->value, $this->getSuitSymbol());
    }

    public function toArray(): array
    {
        return [
            "suit" => $this->suit,
            "value" => $this->value,
            "symbol" => $this->getSuitSymbol(),
            "color" => $this->getColor(),
            "text" => $this->getAsString(),
        ];
    }
}