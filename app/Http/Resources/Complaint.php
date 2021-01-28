<?php

namespace App\Http\Resources;
use App\Http\Resources\Truck as TruckResource;
use App\Models\Neighborhood;
use App\Http\Resources\Neighborhood as NeighborhoodResource;
use App\Models\Truck;
use Illuminate\Http\Resources\Json\JsonResource;

class Complaint extends JsonResource
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
            'complaint'=> $this->complaint,
            'username'=> $this->username,
            'email'=> $this->email,
            'state'=> $this->state,
            'observation'=>$this->observation,
            'truck'=> new TruckResource(Truck::find($this->truck_id)),
//            'neighborhood_id'=> $this->neighborhood_id,
//            'neighborhood'=> new NeighborhoodResource(Neighborhood::find($this->neighborhood_id)),
        ];
    }
}
