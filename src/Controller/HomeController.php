<?php


namespace App\Controller;

use App\Repository\CardRepository;
use MapUx\Model\Icon;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use MapUx\Builder\MapBuilder;
use MapUx\Model\Marker;
use MapUx\Model\Popup;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;


class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="index")
     */

    public function index(): Response
    {


        return $this->render('home/index.html.twig', [
            'hello' => 'hiiiiii'
        ]);
    }

    /**
     * @Route("/game", name="game")
     */

    public function game(CardRepository $cardRepository): Response
    {


        return $this->render('home/game.html.twig', [
            'cards' => $cardRepository->findAll()
        ]);
    }


}