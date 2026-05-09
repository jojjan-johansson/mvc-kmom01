<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProjectController extends AbstractController
{
    #[Route('/proj', name: 'proj_home')]
    public function home(): Response
    {
        // Enkel hårdkodad data (ingen API, ingen databas)
        $data = [
            ["year" => 2020, "value" => 48],
            ["year" => 2021, "value" => 49],
            ["year" => 2022, "value" => 50],
            ["year" => 2023, "value" => 51],
        ];

        return $this->render('proj/index.html.twig', [
            'data' => $data,
        ]);
    }

    #[Route('/proj/about', name: 'proj_about')]
    public function about(): Response
    {
        return $this->render('proj/about.html.twig');
    }
}
