<?php

namespace App\Enums;

enum InventoryChangeType: string
{
    case Restock = 'restock';
    case Sale = 'sale';
    case Return = 'return';
    case Adjustment = 'adjustment';
    case Reservation = 'reservation';
    case ReservationRelease = 'reservation_release';
}
