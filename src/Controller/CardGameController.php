<?php

namespace App\Controller;

use App\Card\DeckOfCards;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

class CardGameController extends AbstractController
{
    private const SESSION_DECK_KEY = "deck_of_cards";

    private function getDeck(SessionInterface $session): DeckOfCards
    {
        $deck = $session->get(self::SESSION_DECK_KEY);

        if (!$deck instanceof DeckOfCards) {
            $deck = new DeckOfCards();
            $session->set(self::SESSION_DECK_KEY, $deck);
        }

        return $deck;
    }

    private function saveDeck(SessionInterface $session, DeckOfCards $deck): void
    {
        $session->set(self::SESSION_DECK_KEY, $deck);
    }

    #[Route("/card", name: "card_index", methods: ["GET"])]
    public function index(): Response
    {
        return $this->render("card/index.html.twig", [
            "title" => "Card",
        ]);
    }

    #[Route("/card/deck", name: "card_deck", methods: ["GET"])]
    public function deck(SessionInterface $session): Response
    {
        $deck = $this->getDeck($session);

        return $this->render("card/deck.html.twig", [
            "title" => "Deck (sorted)",
            "cards" => $deck->getCards(),
            "remaining" => $deck->count(),
        ]);
    }

    #[Route("/card/deck/shuffle", name: "card_deck_shuffle", methods: ["GET"])]
    public function shuffle(SessionInterface $session): Response
    {
        $deck = new DeckOfCards();
        $deck->shuffle();
        $this->saveDeck($session, $deck);

        return $this->render("card/deck.html.twig", [
            "title" => "Deck (shuffled)",
            "cards" => $deck->getCards(),
            "remaining" => $deck->count(),
        ]);
    }

    #[Route("/card/deck/draw", name: "card_deck_draw_one", methods: ["GET"])]
    public function drawOne(SessionInterface $session): Response
    {
        $deck = $this->getDeck($session);
        $drawn = $deck->draw(1);
        $this->saveDeck($session, $deck);

        return $this->render("card/draw.html.twig", [
            "title" => "Draw 1",
            "drawn" => $drawn,
            "remaining" => $deck->count(),
            "number" => 1,
        ]);
    }

    #[Route("/card/deck/draw/{number<\d+>}", name: "card_deck_draw_many", methods: ["GET"])]
    public function drawMany(SessionInterface $session, int $number): Response
    {
        $deck = $this->getDeck($session);
        $drawn = $deck->draw($number);
        $this->saveDeck($session, $deck);

        return $this->render("card/draw.html.twig", [
            "title" => "Draw {$number}",
            "drawn" => $drawn,
            "remaining" => $deck->count(),
            "number" => $number,
        ]);
    }
}
