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

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


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
        $deckDiscardCards=$cardRepository->findBy(['isDiscard' => true]);
        $lastPlayedCard=$cardRepository->findLastPlayedCard();
        $users = $userRepository->findAll();

        $html = $parser->transformMarkdown('**COOOOL**');
        return $this->render('home/game.html.twig', [
            'cards' => $cardRepository->findAll(),
            'players' =>$players,
            'users' => $users,
            'count_cards_in_deck' => count($deckCards),
            'count_cards_in_discard_deck' => count($deckDiscardCards),
            'decks' => $deckCards,
            'html' =>$html,
            'last_played_card' => $lastPlayedCard,
        ]);
    }

    /**

     * @Route("/note", name="note")
     */

    public function noteUpdate(MarkdownParserInterface $parser,ZoneRepository $zoneRepository,UserRepository $userRepository, Request $request, EntityManagerInterface $entityManager): Response

    {
        $text = $request->get('text-to-update');
        $zone = $zoneRepository->findOneBy(['id' =>1]);
        $zone->setInformation($text);
        $entityManager->persist($zone);
        $entityManager->flush();
        return $this->json($zone, 200);

    }

    /**
     * @Route("/shownote", name="note_show")
     */
    public function noteShow(ZoneRepository $zoneRepository)
    {
         $zone = $zoneRepository->findOneBy(['id' =>1]);
         $text=nl2br( $zone->getInformation());
         dd($text);

    }




/**
     * @Route("/newgame", name="new_game")
     */
    public function newGame(CardRepository $cardRepository,UserRepository $userRepository, Request $request, EntityManagerInterface $entityManager): Response

    {

        $players=$userRepository->findAll();
        $lastPlayedCard=$cardRepository->findLastPlayedCard();
        $users = $userRepository->findAll();
        $deckCards=$cardRepository->findBy(['isInDeck' => true]);
        $deckDiscardCards=$cardRepository->findBy(['isDiscard' => true]);

        
        $cards = $cardRepository->findAll();
        foreach ($cards as $card) {
            $card->setUser(null);
            $card->setUserDiscard(null);
            $card->setUser(null);
            $card->setIsPlayed(0);
            $card->setIsVisible(0);
            $card->setIsInDeck(1);
            $card->setIsDiscard(0);
            $this->entityManager->persist($card);
        }

        $this->entityManager->flush();

       return $this->redirectToRoute('game');
    }





}