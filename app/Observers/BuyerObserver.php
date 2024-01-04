<?php

namespace App\Observers;

use App\Models\Buyer;
use App\Services\Zoop;

class BuyerObserver
{
    /**
     * Handle the Buyer "created" event.
     */
    public function created(Buyer $buyer): void
    {
        $zoop = new Zoop() ;
        $zoop->createBuyer($buyer) ;
    }

    /**
     * Handle the Buyer "updated" event.
     */
    public function updated(Buyer $buyer): void
    {
        //
    }

    /**
     * Handle the Buyer "deleted" event.
     */
    public function deleted(Buyer $buyer): void
    {
        //
    }

    /**
     * Handle the Buyer "restored" event.
     */
    public function restored(Buyer $buyer): void
    {
        //
    }

    /**
     * Handle the Buyer "force deleted" event.
     */
    public function forceDeleted(Buyer $buyer): void
    {
        //
    }
}
