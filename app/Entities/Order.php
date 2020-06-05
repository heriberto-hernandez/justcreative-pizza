<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'orders';

    public function  orders()
    {
        return $this->hasMany('App\Entities\OrderPizza', 'number_order');
    }
}
