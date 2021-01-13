<?php


namespace App\Controller;

use App\Form\ZoneType;
use App\Repository\CardRepository;
use App\Repository\ZoneRepository;
use Doctrine\ORM\EntityManagerInterface;
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

    public function game(CardRepository $cardRepository, ZoneRepository $zoneRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $zone = $zoneRepository->findOneBy([]);
        $form = $this->createForm(ZoneType::class, $zone);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($zone);
            $entityManager->flush();
            return $this->json($zone, 200);
        }

        return $this->render('home/game.html.twig', [
            'cards' => $cardRepository->findAll(),
            'zone' => $zone,
            'zoneForm' => $form->createView(),
        ]);
    }


}