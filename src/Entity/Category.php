<?php

declare(strict_types=1);

namespace App\Entity;

/**
 * Class Category
 * @package App\Entity
 */
class Category
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $label;


    public function __toString(): string
    {
        return  $this->label;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @param string $label
     */
    public function setLabel(string $label): void
    {
        $this->label = $label;
    }
}
