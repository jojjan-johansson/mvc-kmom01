<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LuckyController extends AbstractController
{
    #[Route('/lucky', name: 'lucky')]
    public function number(): Response
    {
        $number = random_int(1, 100);

        return $this->render('lucky.html.twig', [
            'number' => $number,
        ]);
    }
}
