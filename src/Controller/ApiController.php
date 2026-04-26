<?php

namespace App\Controller;

use App\Game\Game21;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    #[Route('/api', name: 'api')]
    public function index(): Response
    {
        return $this->render('api/index.html.twig');
    }

    #[Route('/api/status', name: 'api_status')]
    public function status(): JsonResponse
    {
        return $this->json([
            'name' => 'Johanna',
            'course' => 'webapp-mvc',
            'kmom' => 'kmom01',
            'status' => '✅ klar med grunderna',
            'time' => date('Y-m-d H:i:s'),
        ]);
    }

    #[Route('/api/quote', name: 'api_quote')]
    public function quote(): JsonResponse
    {
        $quotes = [
            "Det är aldrig för sent att börja om.",
            "Kod är som konst – låt det vara vackert.",
            "Om det funkar, rör det inte! ",
            "Ändra aldrig ett bra koncept",
        ];

        $randomQuote = $quotes[array_rand($quotes)];

        return $this->json(
            [
                'quote' => $randomQuote,
                'date' => date('Y-m-d'),
                'timestamp' => date('Y-m-d H:i:s'),
            ],
            200,
            [],
            ['json_encode_options' => JSON_UNESCAPED_UNICODE]
        );
    }

    #[Route('/api/game', name: 'api_game', methods: ['GET'])]
    public function game(SessionInterface $session): JsonResponse
    {
        $game = $session->get('game21');

        if (!$game instanceof Game21) {
            return new JsonResponse([
                'message' => 'Inget spel startat',
            ]);
        }

        return new JsonResponse($game->toArray());
    }
}
