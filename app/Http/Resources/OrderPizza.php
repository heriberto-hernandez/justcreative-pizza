<?php

namespace App\Http\Resources;

use App\Entities\Order;
use App\Entities\Pizza;
use App\Http\Resources\Order as OrderResources;
use App\Http\Resources\Pizza as PizzaResources;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderPizza extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'number_order' => $this->number_order,
            'pizzas_id' => $this->pizzas_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'order' => new OrderResources( Order::find($this->number_order) ),
            'pizza' => new PizzaResources( Pizza::find($this->pizzas_id) ),
        ];
    }
}
