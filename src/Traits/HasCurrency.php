<?php

namespace Sumra\SDK\Traits;

use App\Models\Currency;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 *
 * @author Mauricio
 * @property Currency $currency
 */
trait HasCurrency
{
    /**
     *
     * @return BelongsTo
     */
    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    /**
     *
     * @param Currency $currency
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function setCurrency(Currency $currency)
    {
        return $this->currency()->associate($currency);
    }

    /**
     *
     * @return Currency
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     *
     * @return string
     */
    public function getCurrencyCode()
    {
        return $this->getCurrency()->code;
    }
}
