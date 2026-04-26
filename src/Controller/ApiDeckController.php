<?php

namespace App\Controller;

use App\Card\DeckOfCards;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

class ApiDeckController extends AbstractController
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

    #[Route("/api", name: "api_index", methods: ["GET"])]
    public function index(): Response
    {
        return $this->render("api/index.html.twig");
    }

    #[Route("/api/deck", name: "api_deck", methods: ["GET"])]
    public function deck(SessionInterface $session): JsonResponse
    {
        $deck = $this->getDeck($session);

        return $this->json([
            "deck" => $deck->toArray(),
            "remaining" => $deck->count(),
        ]);
    }

    #[Route("/api/deck/shuffle", name: "api_deck_shuffle", methods: ["POST"])]
    public function shuffle(SessionInterface $session): JsonResponse
    {
        $deck = new DeckOfCards();
        $deck->shuffle();
        $this->saveDeck($session, $deck);

        return $this->json([
            "deck" => $deck->toArray(),
            "remaining" => $deck->count(),
        ]);
    }

    #[Route("/api/deck/draw", name: "api_deck_draw_one", methods: ["POST"])]
    public function drawOne(SessionInterface $session): JsonResponse
    {
        $deck = $this->getDeck($session);
        $drawn = $deck->draw(1);
        $this->saveDeck($session, $deck);

        return $this->json([
            "drawn" => array_map(fn ($c) => $c->toArray(), $drawn),
            "remaining" => $deck->count(),
        ]);
    }

    #[Route("/api/deck/draw/{number<\d+>}", name: "api_deck_draw_many", methods: ["POST"])]
    public function drawMany(SessionInterface $session, int $number): JsonResponse
    {
        $deck = $this->getDeck($session);
        $drawn = $deck->draw($number);
        $this->saveDeck($session, $deck);

        return $this->json([
            "drawn" => array_map(fn ($c) => $c->toArray(), $drawn),
            "remaining" => $deck->count(),
            "requested" => $number,
            "actuallyDrawn" => count($drawn),
        ]);
    }
}
