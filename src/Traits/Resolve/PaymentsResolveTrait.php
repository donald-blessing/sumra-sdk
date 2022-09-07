<?php

namespace Sumra\SDK\Traits\Resolve;

use Illuminate\Support\Facades\DB;

trait PaymentsResolveTrait
{
    /**
     * @param $id
     * @return mixed
     */
    public function getPaymentOrderDetail($id): mixed
    {
        // Get Payment order detail
        return DB::connection('payments')
            ->table('payment_orders')
            ->where('id', $id)
            ->first();
    }
}
