<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\Neighborhood;
use App\Http\Resources\Neighborhood as NeighborhoodResource;
use App\Http\Resources\NeighborhoodCollection;
use App\Models\Truck;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NeighborhoodController extends Controller
{
    public function index()
    {
        return new NeighborhoodCollection(Neighborhood::paginate(10));
    }

    public function show(Neighborhood $neighborhood)
    {
        return response()->json(new NeighborhoodResource($neighborhood), 200);;
    }

    public function showNeighborhoodsWithoutTruck(){

        $noTruck = Neighborhood::whereNull('truck_id')->get();
        return response()->json($noTruck, 200);
    }

    public function showNeighborhoodsWithoutComplaints(){

        $complaints = Complaint::all();
        $neighborhoodWithComplaints = array();
        foreach($complaints as $complaint){
            $neighborhoodWithComplaints[] = $complaint['neighborhood_id'];
        }
        $neighborhoods  = Neighborhood::whereNotIn('id', $neighborhoodWithComplaints)->get();

        return response()->json($neighborhoods, 200);
    }


    public function store(Request $request)
    {
        $this->authorize('create',Neighborhood::class);
        $messages= [
            'required'=> 'El campo :attribute es obligatorio.',
        ];

        $request->validate([
            'start_time'=>'required|date_format:H:i:s',
            'end_time'=>'required|date_format:H:i:s|after:start_time',
            'days' =>'required|string|max:255',
            'link' =>'required|string',
            'name'=>'required|string|unique:neighborhoods|max:255',
        ],$messages);

        $neighborhood = Neighborhood::create($request->all());
        return response()->json($neighborhood, 201);
    }

    public function update(Request $request, Neighborhood $neighborhood)
    {
        $this->authorize('update',$neighborhood);
        $messages= [
            'required'=> 'El campo :attribute es obligatorio.',
        ];

        $request->validate([
            'start_time'=>'required|date_format:H:i:s',
            'end_time'=>'required|date_format:H:i:s|after:start_time',
            'days' =>'required|string|max:255',
            'link' =>'required|string',
            'name'=>'required|string|unique:neighborhoods,name,'.$neighborhood->id.'|max:255',
            'truck_id' => 'nullable|exists:trucks,id'
        ],$messages);

        $neighborhood->update($request->all());
        return response()->json($neighborhood, 200);
    }


    public function delete(Neighborhood $neighborhood)
    {
        $this->authorize('delete',$neighborhood);
        $neighborhood->delete();
        return response()->json(null, 204);
    }
}
