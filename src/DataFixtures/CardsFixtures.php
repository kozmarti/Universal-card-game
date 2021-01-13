<?php
namespace App\DataFixtures;
use App\Entity\Card;
use Doctrine\Bundle\FixturesBundle\Fixture;

use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class CardsFixtures extends Fixture implements ContainerAwareInterface
{
    private $container;
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $serializer = $this->container->get('serializer');
        $filepath = realpath("./") . "/src/DataFixtures/cardsapi.csv";
        $datas = $serializer->decode(file_get_contents($filepath), 'csv');
        foreach ( $datas as $data) {
            $card = new Card();
            $card->setImage($data['image']);
            $card->setIsInDeck(true);
            $card->setIsDiscard(false);
            $card->setIsVisible(false);
            $card->setIsPlayed(false);
            $manager->persist($card);
        }
        $manager->flush();
    }
}