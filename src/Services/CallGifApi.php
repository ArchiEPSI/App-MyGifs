<?php

declare(strict_types=1);

namespace App\Services;

use App\Entity\Gif;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Class CallGifApi
 * @package App\Services
 */
class CallGifApi
{
    private $client;
    private $serializer;

    /**
     * CallGifApi constructor.
     * @param HttpClientInterface $client
     */
    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
        $encoders = array(new JsonEncoder());
        $normalizer = new ObjectNormalizer(null, null, null, new ReflectionExtractor());

        $this->serializer = new Serializer([new DateTimeNormalizer(), $normalizer, new ArrayDenormalizer()], $encoders);
    }

    /**
     * @return ArrayCollection
     */
    public function getGifs(): ArrayCollection
    {
        $gifs = new ArrayCollection();

        // envoie de la requête pour récupérer l'utilisateur
        try {
            $response = $this->client->request("GET", "http://172.23.0.5:80/api/gifs/")->getContent();
            $items = json_decode($response);
            dd($response, $items);
            foreach ($items as $item) {
                // récupération du gif
                $gif = $this->serializer->deserialize($item, "App\Entity\gif", "json");
                $gifs->add($gif);
            }

        } catch (ClientExceptionInterface $e) {
            throw new \Exception("Impossible de récupérer la liste de gifs");
        }

        return $gifs;
    }

    /**
     * @param int $id
     *
     * @return Gif
     */
    public function getGif(int $id): Gif
    {
        // envoie de la requête pour récupérer l'utilisateur
        try {
            $response = $this->client->request("GET", "http://172.23.0.5:80/api/gifs/".$id)->getContent();
            //$response = json_decode($response);
            // récupération de l'adresse
            $gif = $this->serializer->deserialize($response, "App\Entity\gif", "json");

        } catch (ClientExceptionInterface $e) {
            throw new \Exception("Impossible de récupérer cet utilisateur");
        }

        return $gif;
    }

    /**
     * @param Gif $gif
     */
    public function editGif(Gif $gif): void
    {
        // sérialisation du l'utilisateur
        $content = $this->serializer->serialize($gif, "json");
        $response = $this->client->request("PUT", "http://172.23.0.5:80/api/fifs/".$gif->getId(),
            [
                'headers' => [
                    'Content-Type' => 'application/json; charset=utf-8',
                ],
                "body" => $content,
            ]
        );
    }

    /**
     * @param Gif $gif
     */
    public function postGif(Gif $gif)
    {
        // sérialisation du l'utilisateur
        $content = $this->serializer->serialize($gif, "json");
        $response = $this->client->request("POST", "http://172.23.0.5:80/api/Gifs",
            [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                "body" => $content,
            ]
        );
    }

}