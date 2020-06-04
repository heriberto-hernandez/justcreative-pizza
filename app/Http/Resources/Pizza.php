<?php

namespace App\Http\Resources;

use App\Entities\Size;
use App\Http\Resources\Size as SizeResources;
use Illuminate\Http\Resources\Json\JsonResource;

class Pizza extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id'=> $this->id,
            'name'=> $this->name,
            'price'=> $this->price,
            'sizes_id'=> $this->sizes_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'size' => new SizeResources( Size::find($this->sizes_id) ),
        ];
    }
}
