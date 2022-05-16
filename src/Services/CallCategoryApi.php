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

    /**
     * CallCategoryApi constructor.
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
     * @param int $id
     *
     * @return Category
     */
    public function getCategory(int $id): Category
    {
        // envoie de la requête pour récupérer l'utilisateur
        try {
            $response = $this->client->request("GET", "http://172.23.0.5:80/api/categories/".$id)->getContent();
            //$response = json_decode($response);
            // récupération de l'adresse
            $category = $this->serializer->deserialize($response, "App\Entity\Category", "json");

        } catch (ClientExceptionInterface $e) {
            throw new \Exception("Impossible de récupérer cet utilisateur");
        }

        return $category;
    }

    /**
     * @return ArrayCollection
     */
    public function getCategories(): ArrayCollection
    {
        $categories = new ArrayCollection();
        // envoie de la requête pour récupérer l'utilisateur
        try {
            $items = $this->client->request("GET", "http://172.23.0.5:80/api/categories")->getContent();
            //$response = json_decode($response);
            foreach ($items as $item) {
                $category = $this->serializer->deserialize($item, "App\Entity\Category", "json");
                $categories->add($category);
            }
        } catch (ClientExceptionInterface $e) {
            throw new \Exception("Impossible de récupérer cet utilisateur");
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
        $response = $this->client->request("PUT", "http://172.23.0.5:80/api/categories/".$category->getId(),
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
        $response = $this->client->request("POST", "http://172.23.0.5:80/api/categories",
            [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                "body" => $content,
            ]
        );
    }
}