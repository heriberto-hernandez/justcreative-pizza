<?php

namespace App\Http\Resources;

use App\User;
use App\Http\Resources\User as UserResources;
use Illuminate\Http\Resources\Json\JsonResource;

class Order extends JsonResource
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
            'id'=> $this->id,
            'number_order'=> $this->number_order,
            'date'=> $this->date,
            'total'=> $this->total,
            'users_id'=> $this->users_id,
            'user' => new UserResources( User::find($this->users_id) ),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
        
    }
}
