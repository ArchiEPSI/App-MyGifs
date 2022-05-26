<?php

declare(strict_types=1);

namespace App\Services;

use App\Entity\Gif;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Calculs
 */
class Calculs
{
    /**
     * @param ArrayCollection $gifs
     *
     * @return float
     */
    public function getTotal(ArrayCollection $gifs): float
    {
        $total = 0;

        /** @var Gif $gif */
        foreach ($gifs as $gif) {
            $total = $total + $gif->getPrice();
        }

        return $total;
    }
}