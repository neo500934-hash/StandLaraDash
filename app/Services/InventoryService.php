<?php

namespace App\Services;

use App\Enums\InventoryChangeType;
use App\Exceptions\InsufficientStockException;
use App\Models\Inventory;
use App\Models\InventoryTransaction;
use Illuminate\Support\Facades\DB;

class InventoryService
{
    public function reserve(int $variantId, int $qty, string $referenceId): bool
    {
        return DB::transaction(function () use ($variantId, $qty, $referenceId) {
            Inventory::whereKey($variantId)->lockForUpdate()->first();

            $affected = DB::table('inventory')
                ->where('variant_id', $variantId)
                ->whereRaw('quantity_on_hand - quantity_reserved >= ?', [$qty])
                ->update([
                    'quantity_reserved' => DB::raw("quantity_reserved + {$qty}"),
                    'updated_at' => now(),
                ]);

            if ($affected === 0) {
                return false;
            }

            $this->logTransaction($variantId, InventoryChangeType::Reservation, $qty, $referenceId);

            return true;
        });
    }

    public function releaseReservation(int $variantId, int $qty, string $referenceId): void
    {
        DB::transaction(function () use ($variantId, $qty, $referenceId) {
            DB::table('inventory')
                ->where('variant_id', $variantId)
                ->decrement('quantity_reserved', $qty, ['updated_at' => now()]);

            $this->logTransaction($variantId, InventoryChangeType::ReservationRelease, $qty, $referenceId);
        });
    }

    public function confirmSale(int $variantId, int $qty, string $referenceId): void
    {
        DB::transaction(function () use ($variantId, $qty, $referenceId) {
            $locked = Inventory::whereKey($variantId)->lockForUpdate()->first();

            if (! $locked || $locked->quantity_on_hand < $qty || $locked->quantity_reserved < $qty) {
                throw new InsufficientStockException($variantId, $qty);
            }

            DB::table('inventory')
                ->where('variant_id', $variantId)
                ->update([
                    'quantity_on_hand' => DB::raw("quantity_on_hand - {$qty}"),
                    'quantity_reserved' => DB::raw("quantity_reserved - {$qty}"),
                    'updated_at' => now(),
                ]);

            $this->logTransaction($variantId, InventoryChangeType::Sale, -$qty, $referenceId);
        });
    }

    public function restock(int $variantId, int $qty, ?string $referenceId = null): void
    {
        DB::transaction(function () use ($variantId, $qty, $referenceId) {
            DB::table('inventory')
                ->where('variant_id', $variantId)
                ->increment('quantity_on_hand', $qty, ['updated_at' => now()]);

            $this->logTransaction($variantId, InventoryChangeType::Restock, $qty, $referenceId);
        });
    }

    public function adjust(int $variantId, int $delta, ?string $referenceId = null): void
    {
        DB::transaction(function () use ($variantId, $delta, $referenceId) {
            DB::table('inventory')
                ->where('variant_id', $variantId)
                ->update([
                    'quantity_on_hand' => DB::raw("quantity_on_hand + ({$delta})"),
                    'updated_at' => now(),
                ]);

            $this->logTransaction($variantId, InventoryChangeType::Adjustment, $delta, $referenceId);
        });
    }

    public function soldQuantity(int $variantId): int
    {
        return (int) abs(
            InventoryTransaction::where('variant_id', $variantId)
                ->where('change_type', InventoryChangeType::Sale)
                ->sum('quantity_delta')
        );
    }

    private function logTransaction(int $variantId, InventoryChangeType $type, int $delta, ?string $referenceId): void
    {
        InventoryTransaction::create([
            'variant_id' => $variantId,
            'change_type' => $type,
            'quantity_delta' => $delta,
            'reference_id' => $referenceId,
        ]);
    }
}
