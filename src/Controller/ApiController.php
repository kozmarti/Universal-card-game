<?php


namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ApiController extends AbstractController
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }
    /**
     * @Route("/cards", name="cards")
     */

    public function cardsApiData(): array
    {
        $response = $this->client->request(
            'GET',
            'https://deckofcardsapi.com/api/deck/new/shuffle/?deck_count=1'
        );

        $statusCode = $response->getStatusCode();
        // $statusCode = 200
        $contentType = $response->getHeaders()['content-type'][0];
        // $contentType = 'application/json'
        $content = $response->getContent();
        // $content = '{"id":521583, "name":"symfony-docs", ...}'
        $content = $response->toArray();
        $cards= $this->client->request(
            'GET',
            'https://deckofcardsapi.com/api/deck/new/draw/?count=52'
        );
        $cards2= $cards->toArray();
        dd($cards2);
        // $content = ['id' => 521583, 'name' => 'symfony-docs', ...]

        return $this->render('home/index.html.twig', [
            'hello' => 'hiiiiii'
        ]);
    }

}