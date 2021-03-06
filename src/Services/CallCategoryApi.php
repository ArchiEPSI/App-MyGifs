<?php

declare(strict_types=1);

namespace App\Services;

use App\Entity\Category;
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
 * Class CallCategoryApi
 * @package App\Services
 */
class CallCategoryApi
{
    private $client;
    private $serializer;
    private $platformApiUrl;


    /**
     * CallCategoryApi constructor.
     * @param HttpClientInterface $client
     */
    public function __construct(HttpClientInterface $client, string $platformApiUrl)
    {
        $this->client = $client;
        $this->platformApiUrl = $platformApiUrl;
        $encoders = array(new JsonEncoder());
        $normalizer = new ObjectNormalizer(null, null, null, new ReflectionExtractor());

        $this->serializer = new Serializer([new DateTimeNormalizer(), $normalizer, new ArrayDenormalizer()], $encoders);
    }

    /**
     * @param int $id
     *
     * @return Category
     */
    public function getCategory(int $id): Category
    {
        // envoie de la requête pour récupérer l'utilisateur
        try {
            $response = $this->client->request("GET", $this->platformApiUrl."/api/categories/".$id)->getContent();
            //$response = json_decode($response);
            // récupération de l'adresse
            $category = $this->serializer->deserialize($response, "App\Entity\Category", "json");

        } catch (ClientExceptionInterface $e) {
            throw new \Exception("Impossible de récupérer cet utilisateur");
        }

        return $category;
    }

    /**
     * @return array
     */
    public function getCategories(): array
    {
        $categories = [];
        // envoie de la requête pour récupérer l'utilisateur
        try {
            $response = $this->client->request("GET", $this->platformApiUrl."/api/categories")->getContent();
            $gifsJson = json_decode($response, true);
            foreach ($gifsJson["hydra:member"] as $item) {
                $item = json_encode($item);
                /** @var Category $category */
                $category = $this->serializer->deserialize($item, "App\Entity\Category", "json");
                $categories[$category->getLabel()] = ($category);
            }
        } catch (ClientExceptionInterface $e) {
            return $categories;
        }

        return $categories;
    }

    /**
     * @param Category $category
     */
    public function postCategory(Category $category): void
    {
        // sérialisation du l'utilisateur
        $content = $this->serializer->serialize($category, "json");
        $response = $this->client->request("PUT", $this->platformApiUrl."/api/categories/".$category->getId(),
            [
                'headers' => [
                    'Content-Type' => 'application/json; charset=utf-8',
                ],
                "body" => $content,
            ]
        );
    }

    /**
     * @param Category $category
     */
    public function addCategory(Category $category)
    {
        // sérialisation du l'utilisateur
        $content = $this->serializer->serialize($category, "json");
        $response = $this->client->request("POST", $this->platformApiUrl."/api/categories",
            [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                "body" => $content,
            ]
        );
    }
}