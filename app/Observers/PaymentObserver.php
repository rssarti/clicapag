<?php

namespace App\Observers;

use App\Models\Payment;
use App\Services\PaymentService;

class PaymentObserver extends PaymentService
{
    /**
     * Handle the Payment "created" event.
     */
    public function created(Payment $payment): void
    {

        $payment = Payment::find($payment->id) ;

        if($payment->status=="PEN") { // PAGAMENTO PENDENTE
            $this->observerCreatedPending($payment);
        }
    }

    /**
     * Handle the Payment "updated" event.
     */
    public function updated(Payment $payment): void
    {
        //
    }

    /**
     * Handle the Payment "deleted" event.
     */
    public function deleted(Payment $payment): void
    {
        //
    }

    /**
     * Handle the Payment "restored" event.
     */
    public function restored(Payment $payment): void
    {
        //
    }

    /**
     * Handle the Payment "force deleted" event.
     */
    public function forceDeleted(Payment $payment): void
    {
        //
    }
}
