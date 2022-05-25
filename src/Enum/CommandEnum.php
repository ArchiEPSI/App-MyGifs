<?php

declare(strict_types=1);

namespace App\Enum;

class CommandEnum
{
    const TYPE_SELL = "Vente";
    const TYPE_BUY = "Achat";

    const STATE_WAITING = "En attente";
    const STATE_CLOSE = "Terminée";
    const STATE_CANCEL = "Annulée";
}