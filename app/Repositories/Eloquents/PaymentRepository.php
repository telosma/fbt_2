<?php

namespace App\Repositories\Eloquents;

use App\Models\Payment;

class PaymentRepository extends BaseRepository
{

    public function __construct(Payment $payment)
    {
        parent::__construct();
        $this->model = $payment;
    }

    public function model()
    {
        return Payment::class;
    }
}
