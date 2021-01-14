<?php


namespace App\Controller;

use App\Form\ZoneType;
use App\Repository\CardRepository;
use App\Repository\UserRepository;
use App\Repository\ZoneRepository;
use Doctrine\ORM\EntityManagerInterface;
use MapUx\Model\Icon;
use phpDocumentor\Reflection\Types\String_;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use MapUx\Builder\MapBuilder;
use MapUx\Model\Marker;
use MapUx\Model\Popup;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;
use Knp\Bundle\MarkdownBundle\MarkdownParserInterface;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="index")
     */

    public function index(): Response
    {



        return $this->render('home/index.html.twig', [

        ]);
    }

    /**
     * @Route("/game", name="game")
     */


    public function game(MarkdownParserInterface $parser,CardRepository $cardRepository, ZoneRepository $zoneRepository,UserRepository $userRepository, Request $request, EntityManagerInterface $entityManager): Response

    {


        $players=$userRepository->findAll();
        $deckCards=$cardRepository->findBy(['isInDeck' => true]);
        $lastPlayedCard=$cardRepository->findLastPlayedCard();
        $users = $userRepository->findAll();

        $html = $parser->transformMarkdown('**COOOOL**');
        return $this->render('home/game.html.twig', [
            'cards' => $cardRepository->findAll(),
            'players' =>$players,
            'users' => $users,
            'count_cards_in_deck' => count($deckCards),
            'decks' => $deckCards,
            'last_played_card' => $lastPlayedCard,

            'html' =>$html

        ]);
    }

    /**
     * @Route("/note", name="note")
     */

    public function noteUpdate(MarkdownParserInterface $parser,ZoneRepository $zoneRepository,UserRepository $userRepository, Request $request, EntityManagerInterface $entityManager): Response

    {
        $text = $request->get('text-to-update');
        $html = $parser->transformMarkdown($text);
        $zone = $zoneRepository->findOneBy(['id' =>1]);
        $zone->setInformation($html);
        $entityManager->persist($zone);
        $entityManager->flush();

        return $this->json($zone, 200);

    }



}