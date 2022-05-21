<?php

declare(strict_types=1);

namespace App\Enum;

use function Symfony\Component\Routing\Annotation\setLocalizedPaths;

/**
 * Class GifStateEnum
 * @package App\Enum
 */
class GifStateEnum
{
    const SELL = "A vendre";
    const SELLED = "Vendu";
    const WAITING = "En attente";

    const STATE_LIST = [
        "SELL" => self::SELL,
        "SELLED" => self::SELLED,
        "WAIT" => self::WAITING,
    ];
}