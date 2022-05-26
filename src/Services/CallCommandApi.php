<?php

declare(strict_types=1);

namespace App\Services;

use App\Entity\Command;
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
 * Class CallCommandApi
 * @package App\Services
 */
class CallCommandApi
{
    private $client;
    private $serializer;
    private $platformApiUrl;

    /**
     * CallCommandApi constructor.
     * @param HttpClientInterface $client
     * @param string $platformApiUrl
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
     * @return Command
     */
    public function getCommand(int $id): Command
    {
        // envoie de la requête pour récupérer l'utilisateur
        try {
            $response = $this->client->request("GET", $this->platformApiUrl."/api/categories/".$id)->getContent();
            //$response = json_decode($response);
            // récupération de l'adresse
            $command = $this->serializer->deserialize($response, "App\Entity\Command", "json");

        } catch (ClientExceptionInterface $e) {
            throw new \Exception("Impossible de récupérer cet utilisateur");
        }

        return $command;
    }
    /**
     * @return Command
     */
    public function getCart(): Command
    {
        // envoie de la requête pour récupérer l'utilisateur
        try {
            $response = $this->client->request("GET", $this->platformApiUrl."/api/commands/")->getContent();
            //$response = json_decode($response);
            // récupération de l'adresse
            $command = $this->serializer->deserialize($response, "App\Entity\Command", "json");

        } catch (ClientExceptionInterface $e) {
            throw new \Exception("Impossible de récupérer cet utilisateur");
        }

        return $command;
    }

    /**
     * @return ArrayCollection
     */
    public function getCommands(): ArrayCollection
    {
        $commands = new ArrayCollection();
        // envoie de la requête pour récupérer l'utilisateur
        try {
            $items = $this->client->request("GET", $this->platformApiUrl."/api/categories")->getContent();
            //$response = json_decode($response);
            foreach ($items as $item) {
                $command = $this->serializer->deserialize($item, "App\Entity\Command", "json");
                $commands->add($command);
            }
        } catch (ClientExceptionInterface $e) {
            throw new \Exception("Impossible de récupérer cet utilisateur");
        }

        return $commands;
    }

    /**
     * @param Command $command
     */
    public function postCommand(Command $command): void
    {
        // sérialisation du l'utilisateur
        $content = $this->serializer->serialize($command, "json");
        $response = $this->client->request("PUT", $this->platformApiUrl."/api/categories/".$command->getId(),
            [
                'headers' => [
                    'Content-Type' => 'application/json; charset=utf-8',
                ],
                "body" => $content,
            ]
        );
    }

    /**
     * @param Command $command
     */
    public function addCommand(Command $command)
    {
        // sérialisation du l'utilisateur
        $content = $this->serializer->serialize($command, "json");
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