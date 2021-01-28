<?php

namespace App\Http\Resources;

use App\Models\User;
use App\Http\Resources\User as UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class Truck extends JsonResource
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
            'license_plate'=>$this->license_plate,
            'type' => $this->type,
            'working' => $this->working,
            'user'=> new UserResource(User::find($this->user_id)),
        ];
    }
}
