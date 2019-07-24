<?php
namespace Alura\BuscadorDeCursos;

use Symfony\Component\DomCrawler\Crawler;
use GuzzleHttp\ClientInterface;

class Buscador
{
    private $httpClient;
    private $crawler;

    public function __construct(ClientInterface $httpClient, Crawler $crawler)
    {
        $this->httpClient = $httpClient;
        $this->crawler = $crawler;
    }

    public function buscar(string $url): array
    {
        $response = $this->httpClient->request('GET', $url);
        $html = $response->getBody();

        // $this->crawler($html); // Também funciona ao invés do addHtmlContent($html)
        $this->crawler->addHtmlContent($html);

        $elementosCursos = $this->crawler->filter('h4.formacao-passo-nome');
        $cursos = [];

        foreach ($elementosCursos as $elem) {
            $cursos[] = $elem->textContent;
        }

        return $cursos;
    }
}
