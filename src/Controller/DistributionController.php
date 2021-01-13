<?php

namespace App\Controller;

use App\Repository\CardRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class DistributionController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/dis", name="dis")
     */
    public function index(UserRepository $userRepository, Request $request): Response
    {

        $users = $userRepository->findAll();

        return $this->render('home/_game_distrib.html.twig', [
            'users' => $users,

        ]);
    }

    /**
     * @Route("/distribute", name="distribute")
     */
    public function distribute(UserRepository $userRepository, Request $request, CardRepository $cardRepository): Response
    {
        $distributionNumbers = $request->request->all();
        $cardsInDeck = $cardRepository->findBy(['isInDeck' => 1]);
        foreach ($cardsInDeck as $cardInDeck) {
            $cardIds[] = $cardInDeck->getId();
        }

        foreach ($distributionNumbers as $userId => $distributionNumber) {
            for ($i = 1; $i < $distributionNumber + 1; $i++) {
                $randCardsId = array_rand(array_flip($cardIds));
                $key = array_search($randCardsId, $cardIds);
                unset($cardIds[$key]);
                $card = $cardRepository->find($randCardsId);
                $user = $userRepository->find($userId);
                $card->setUser($user);
                $card->setIsInDeck(0);
                $this->entityManager->persist($card);
            }
        }

        $this->entityManager->flush();


        return $this->redirectToRoute('game');
    }

    /**
     * @Route("/playcard", name="play_card")
     */
    public function playCard(UserRepository $userRepository, Request $request, CardRepository $cardRepository): Response
    {
        $cardToPlay = $request->request->all();

        $card = $cardRepository->find($cardToPlay['card-to-play']);

        $card->setIsPlayed(1);
        $card->setUser(null);
        $this->entityManager->persist($card);
        $this->entityManager->flush();

dd("yes");
        return $this->redirectToRoute('game');
    }


}