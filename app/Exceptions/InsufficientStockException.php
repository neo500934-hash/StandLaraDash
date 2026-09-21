<?php

namespace App\Exceptions;

use Exception;

class InsufficientStockException extends Exception
{
    public function __construct(public readonly int $variantId, public readonly int $requestedQuantity)
    {
        parent::__construct("Insufficient stock for variant {$variantId}: requested {$requestedQuantity}.");
    }
}
