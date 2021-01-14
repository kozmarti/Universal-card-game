<?php

namespace App\Controller;

use App\Entity\Card;
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
     * @Route("/distribute/discard", name="distribute_discard")
     */
    public function distributeInPersoDiscard(UserRepository $userRepository, Request $request, CardRepository $cardRepository): Response
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
                $card->setUserDiscard($user);
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
        $card->setIsVisible(1);
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
        $card->setIsVisible(1);
        $card->setIsInDeck(0);
        $this->entityManager->persist($card);
        $this->entityManager->flush();


        return $this->redirectToRoute('game');
    }


    /**
     * @Route("/putbackdiscerded", name="put_back_discarded")
     */
    public function putBackDiscarded(UserRepository $userRepository, CardRepository $cardRepository): Response
    {
        $cardsDiscardDeck = $cardRepository->findBy(['isDiscard' => 1]);
        foreach ($cardsDiscardDeck as $card) {
            $card->setIsPlayed(0);
            $card->setIsVisible(0);
            $card->setIsDiscard(0);
            $card->setIsInDeck(1);
            $card->setUserDiscard(null);
            $card->setUser(null);
            $this->entityManager->persist($card);
        }


        $this->entityManager->flush();


        return $this->redirectToRoute('game');
    }


    /**
     * @Route("/showmycards", name="show_my_cards")
     */
    public function showMyCards(UserRepository $userRepository, CardRepository $cardRepository): Response
    {
        $cardsInHand = $cardRepository->findBy(['user' => $this->getUser()]);
        foreach ($cardsInHand as $card) {
            $card->setIsVisible(1);
            $this->entityManager->persist($card);
        }
        $this->entityManager->flush();
        return $this->redirectToRoute('game');
    }


    /**
     *  @Route("/discardCardsPersonal", name="discard_cards_personal")
     */
    public function discardCardsPersonal(CardRepository $cardRepository): Response
    {
        $user = $this->getUser();
        $visibleCards = $cardRepository->findBy(['isVisible' => 1]);
        foreach ($visibleCards as $visibleCard) {
            $visibleCard->setUserDiscard($user);
            $visibleCard->setUser(null);
            $visibleCard->setIsVisible(0);
            $visibleCard->setIsPlayed(0);
            $this->entityManager->persist($visibleCard);
        }

        $playedCards = $cardRepository->findBy(['isPlayed' => 1]);
        foreach ($playedCards as $visibleCard) {
            $visibleCard->setUserDiscard($user);
            $visibleCard->setIsVisible(0);
            $visibleCard->setIsPlayed(0);
            $visibleCard->setUser(null);
            $this->entityManager->persist($visibleCard);
        }

        $this->entityManager->flush();
        return $this->redirectToRoute('game');
    }

    /**
     *  @Route("/discardmyshowedcards", name="discard_my_showed_cards")
     */
    public function discardMyShowedCards(CardRepository $cardRepository): Response
    {
        $user = $this->getUser();
        $visibleCards = $cardRepository->findBy(['isVisible' => 1, 'user'=>$user]);
        foreach ($visibleCards as $visibleCard) {
            $visibleCard->setUserDiscard(null);
            $visibleCard->setUser(null);
            $visibleCard->setIsDiscard(1);
            $visibleCard->setIsVisible(0);
            $visibleCard->setIsPlayed(0);
            $this->entityManager->persist($visibleCard);
        }

        $this->entityManager->flush();
        return $this->redirectToRoute('game');
    }




    /**
     *  @Route("/discardAllCards", name="discard_all_cards")
     */
    public function discardAllCards(Request $request,CardRepository $cardRepository): Response
    {
        $visibleCards = $cardRepository->findBy(['isVisible' => 1, 'user'=>null]);
        foreach ($visibleCards as $visibleCard) {
        $visibleCard->setUser(null);
        $visibleCard->setIsDiscard(1);
        $visibleCard->setIsVisible(0);
        $visibleCard->setIsPlayed(0);
        $this->entityManager->persist($visibleCard);
    }

        $playedCards = $cardRepository->findBy(['isPlayed' => 1]);

        foreach ($playedCards as $visibleCard) {
            $visibleCard->setUser(null);
            $visibleCard->setIsDiscard(1);
            $visibleCard->setIsVisible(0);
            $visibleCard->setIsPlayed(0);
            $this->entityManager->persist($visibleCard);
        }

        $this->entityManager->flush();
        return $this->redirectToRoute('game');
    }

    /**
     * @Route("/takeCard", name="take_card")
     */
    public function takeCard(Request $request,CardRepository $cardRepository): Response
    {
        $cardToTake = $request->request->all();
        $card = $cardRepository->find($cardToTake['card-to-take']);
        $card->setUser($this->getUser());
        $card->setIsVisible(0);
        $card->setIsPlayed(0);
        $card->setIsDiscard(0);
        $card->setUserDiscard(null);
        $this->entityManager->persist($card);
        $this->entityManager->flush();
        return $this->redirectToRoute('game');
    }


    /**
     *  @Route("/showOneDiscardedPersonalCard", name="show_one_discarded_personal_card")
     */
    public function showOneDiscardedPersonalCard(CardRepository $cardRepository): Response
    {
        $cardDiscardPerso = $cardRepository->findBy(['userDiscard' => $this->getUser()]);
        foreach ($cardDiscardPerso as $card) {
            $card->setIsVisible(1);
            $card->setUser($this->getUser());
            $card->setUserDiscard(null);
            $this->entityManager->persist($card);
        }
        $this->entityManager->flush();
        return $this->redirectToRoute('game');
    }


    /**
     *  @Route("/showLastDiscardedPersonalCard", name="show_last_discarded_personal_card")
     */
    public function showLastDiscardedPersonalCard(CardRepository $cardRepository): Response
    {
        $user = $this->getUser();
        $card = $cardRepository->findLastDiscardedCard($user);
        if ($card) {
            $card->setIsVisible(1);
            $card->setUser(null);
            $card->setUserDiscard(null);
            $this->entityManager->persist($card);
            $this->entityManager->flush();
        }
        return $this->redirectToRoute('game');
    }
}