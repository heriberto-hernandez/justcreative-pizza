<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Relations\Pivot;

class OrderPizza extends Pivot
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'order_pizza';
}