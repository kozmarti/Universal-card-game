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
     * @Route("/distributeOneCard", name="distribute_one_card")
     */
    public function distributeOneCard(UserRepository $userRepository, Request $request, CardRepository $cardRepository): Response
    {

        $cardsInDeck = $cardRepository->findBy(['isInDeck' => 1]);
        foreach ($cardsInDeck as $cardInDeck) {
            $cardIds[] = $cardInDeck->getId();
        }

        $randCardsId = array_rand(array_flip($cardIds));
        $key = array_search($randCardsId, $cardIds);
        unset($cardIds[$key]);
        $card = $cardRepository->find($randCardsId);
        $user = $this->getUser();
        $card->setUser($user);
        $card->setIsInDeck(0);
        $this->entityManager->persist($card);

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

      return $this->redirectToRoute('game');
    }

    /**
     * @Route("/playdeckcard", name="play_deck_card")
     */
    public function playDeckCard(UserRepository $userRepository, Request $request, CardRepository $cardRepository): Response
    {
        $cardsInDeck = $cardRepository->findBy(['isInDeck' => 1]);
        foreach ($cardsInDeck as $cardInDeck) {
            $cardIds[] = $cardInDeck->getId();
        }
        $randCardsId = array_rand(array_flip($cardIds));
        $card = $cardRepository->find($randCardsId);
        $card->setIsPlayed(1);
        $card->setIsInDeck(0);
        $this->entityManager->persist($card);
        $this->entityManager->flush();


        return $this->redirectToRoute('game');
    }

    /**
     *  * @Route("/discardCardPersonal", name="discard_card_personal")
     */
    public function discardCardPersonal(Request $request,CardRepository $cardRepository): Response
    {
        $userId = $this->getUser();
        $cardToPlay = $request->request->all();
        $card = $cardRepository->find($cardToPlay['card-to-play']);
        $card->setUserDiscard($userId);
        $card->setUser(null);
        $this->entityManager->persist($card);
        $this->entityManager->flush();
        return $this->redirectToRoute('game');
    }

}