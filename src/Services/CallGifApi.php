<?php

declare(strict_types=1);

namespace App\Services;

use App\Entity\Category;
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
    private HttpClientInterface $client;
    private Serializer $serializer;

    const URI = "http://172.23.0.4:80/api/gifs";
    const URI_USER = "/api/users/";
    const URI_CATEGORY = "/api/categories/";

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
            $response = $this->client->request("GET", self::URI)->getContent();
            $response = json_decode($response, true);
            foreach ($response["hydra:member"] as $item) {
                $item = json_encode($item);
                $gif = $this->serializer->deserialize($item, "App\Entity\Gif", "json");
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
            $response = $this->client->request("GET", self::URI."/".$id)->getContent();
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
        $response = $this->client->request("PUT", self::URI."/".$gif->getId(),
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
        // modification des données
        $content = json_decode($content, true);
        // modification owner en uri pour éviter la création dun nouvel user
        $content["owner"] = self::URI_USER.$gif->getOwner()->getUserIdentifier();
        // modification des catégories en uri
        /** @var Category $category */
        foreach ($gif->getCategories() as $index =>$category) {
            $content["categories"][$index] = self::URI_CATEGORY.$category->getId();
        }
        $response = $this->client->request("POST", "http://172.23.0.4:80/api/gifs",
            [
                'headers' => [
                    'Content-Type' => 'application/json; charset=utf-8',
                ],
                "body" => json_encode($content),
            ]
        );
    }
}