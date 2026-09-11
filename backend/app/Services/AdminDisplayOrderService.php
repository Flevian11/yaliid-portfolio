<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;

class AdminDisplayOrderService
{
    /**
     * Assign the next display position to a newly-created model.
     *
     * Existing positions are preserved. The admin UI never needs to
     * provide display_order manually.
     */
    public function assignNext(Model $model): int
    {
        $max = $model->newQuery()->max('display_order');

        return ((int) $max) + 1;
    }
}
