<?php

namespace App\Game;

use App\Card\Card;
use App\Card\CardHand;
use App\Card\DeckOfCards;

class Game21
{
    private DeckOfCards $deck;
    private CardHand $playerHand;
    private CardHand $bankHand;
    private bool $gameOver = false;
    private ?string $winner = null;
    private string $status = "Nytt spel startat.";

    public function __construct()
    {
        $this->deck = new DeckOfCards();
        $this->deck->shuffle();

        $this->playerHand = new CardHand();
        $this->bankHand = new CardHand();
    }

    public function getDeck(): DeckOfCards
    {
        return $this->deck;
    }

    public function getPlayerHand(): CardHand
    {
        return $this->playerHand;
    }

    public function getBankHand(): CardHand
    {
        return $this->bankHand;
    }

    public function isGameOver(): bool
    {
        return $this->gameOver;
    }

    public function getWinner(): ?string
    {
        return $this->winner;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function drawPlayerCard(): void
    {
        if ($this->gameOver) {
            return;
        }

        $drawnCards = $this->deck->draw(1);

        if ($drawnCards === []) {
            $this->gameOver = true;
            $this->winner = "bank";
            $this->status = "Kortleken är slut. Banken vinner.";
            return;
        }

        $this->playerHand->add($drawnCards[0]);

        if ($this->getPlayerScore() > 21) {
            $this->gameOver = true;
            $this->winner = "bank";
            $this->status = "Spelaren blev tjock. Banken vinner.";
            return;
        }

        $this->status = "Spelaren drog ett kort.";
    }

    public function bankPlay(): void
    {
        if ($this->gameOver) {
            return;
        }

        while ($this->getBankScore() < 17) {
            $drawnCards = $this->deck->draw(1);

            if ($drawnCards === []) {
                break;
            }

            $this->bankHand->add($drawnCards[0]);
        }

        $playerScore = $this->getPlayerScore();
        $bankScore = $this->getBankScore();

        $this->gameOver = true;

        if ($bankScore > 21) {
            $this->winner = "player";
            $this->status = "Banken blev tjock. Spelaren vinner.";
            return;
        }

        if ($bankScore >= $playerScore) {
            $this->winner = "bank";
            $this->status = "Banken vinner.";
            return;
        }

        $this->winner = "player";
        $this->status = "Spelaren vinner.";
    }

    public function getPlayerScore(): int
    {
        return $this->calculateScore($this->playerHand);
    }

    public function getBankScore(): int
    {
        return $this->calculateScore($this->bankHand);
    }

    private function calculateScore(CardHand $hand): int
    {
        $score = 0;
        $aces = 0;

        foreach ($hand->getCards() as $card) {
            $value = $this->getCardValue($card);

            if ($card->getValue() === "A") {
                $aces++;
            }

            $score += $value;
        }

        while ($aces > 0 && $score + 13 <= 21) {
            $score += 13;
            $aces--;
        }

        return $score;
    }

    private function getCardValue(Card $card): int
    {
        return match ($card->getValue()) {
            "A" => 1,
            "J" => 11,
            "Q" => 12,
            "K" => 13,
            default => (int) $card->getValue(),
        };
    }

    public function toArray(): array
    {
        return [
            "player" => [
                "cards" => $this->playerHand->toArray(),
                "score" => $this->getPlayerScore(),
            ],
            "bank" => [
                "cards" => $this->bankHand->toArray(),
                "score" => $this->getBankScore(),
            ],
            "deck_count" => $this->deck->count(),
            "game_over" => $this->gameOver,
            "winner" => $this->winner,
            "status" => $this->status,
        ];
    }
}