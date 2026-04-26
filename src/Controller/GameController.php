<?php

namespace App\Controller;

use App\Game\Game21;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    #[Route("/game", name: "game_index", methods: ["GET"])]
    public function index(): Response
    {
        return $this->render('game/index.html.twig');
    }

    #[Route("/game/doc", name: "game_doc", methods: ["GET"])]
    public function doc(): Response
    {
        return $this->render('game/doc.html.twig');
    }

    #[Route("/game/init", name: "game_init", methods: ["POST"])]
    public function init(SessionInterface $session): Response
    {
        $game = new Game21();
        $session->set("game21", $game);

        return $this->redirectToRoute("game_play");
    }

    #[Route("/game/play", name: "game_play", methods: ["GET"])]
    public function play(SessionInterface $session): Response
    {
        $game = $session->get("game21");

        if (!$game instanceof Game21) {
            return $this->redirectToRoute("game_index");
        }

        return $this->render('game/play.html.twig', [
            'playerCards' => $game->getPlayerHand()->getCards(),
            'bankCards' => $game->getBankHand()->getCards(),
            'playerScore' => $game->getPlayerScore(),
            'bankScore' => $game->getBankScore(),
            'gameOver' => $game->isGameOver(),
            'winner' => $game->getWinner(),
            'status' => $game->getStatus(),
        ]);
    }

    #[Route("/game/draw", name: "game_draw", methods: ["POST"])]
    public function draw(SessionInterface $session): Response
    {
        $game = $session->get("game21");

        if (!$game instanceof Game21) {
            return $this->redirectToRoute("game_index");
        }

        $game->drawPlayerCard();
        $session->set("game21", $game);

        return $this->redirectToRoute("game_play");
    }

    #[Route("/game/stand", name: "game_stand", methods: ["POST"])]
    public function stand(SessionInterface $session): Response
    {
        $game = $session->get("game21");

        if (!$game instanceof Game21) {
            return $this->redirectToRoute("game_index");
        }

        $game->bankPlay();
        $session->set("game21", $game);

        return $this->redirectToRoute("game_play");
    }
}
