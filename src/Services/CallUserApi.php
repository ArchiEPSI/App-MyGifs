<?php

declare(strict_types=1);

namespace App\Services;

use App\Entity\User;
use Doctrine\DBAL\Exception\DatabaseDoesNotExist;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Class CallUserAPI
 */
class CallUserApi
{
    private $client;
    private $serializer;

    /**
     * CallUserApi constructor.
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
     * @return User
     */
    public function getUser(int $id): User
    {
        // envoie de la requête pour récupérer l'utilisateur
        try {
                $response = $this->client->request("GET", "http://172.23.0.4:80/api/users/".$id)->getContent();
                //$response = json_decode($response);
                // récupération de l'adresse
            $user = $this->serializer->deserialize($response, "App\Entity\User", "json");

        } catch (ClientExceptionInterface $e) {
            throw new \Exception("Impossible de récupérer cet utilisateur");
        }

        return $user;
    }

    /**
     * @param User $user
     */
    public function postUser(User $user): void
    {
        // sérialisation du l'utilisateur
        $content = $this->serializer->serialize($user, "json");
        $response = $this->client->request("PUT", "http://172.23.0.4:80/api/users/".$user->getId(),
            [
                'headers' => [
                    'Content-Type' => 'application/json; charset=utf-8',
                ],
                "body" => $content,
                ]
        );
    }

    /**
     * @param User $user
     */
    public function addUser(User $user)
    {
        // sérialisation du l'utilisateur
        $content = $this->serializer->serialize($user, "json");
        $response = $this->client->request("POST", "http://172.23.0.4:80/api/users",
            [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                "body" => $content,
            ]
        );
    }
}