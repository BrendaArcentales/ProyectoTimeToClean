<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Http\Resources\Complaint as ComplaintResource;
use App\Http\Resources\ComplaintCollection as ComplaintCollection;
use App\Models\Neighborhood;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    public function index(){
        $this->authorize('viewAny',Complaint::class);
        return new ComplaintCollection(Complaint::paginate(20));
    }
    public function show(Complaint $complaint){
        $this->authorize('view',$complaint);
        return response()->json(new ComplaintResource($complaint),200);
    }

    public function showDriversWithComplaints(){

        $this->authorize('viewDriversWithComplaints',Complaint::class);
        $drivers = array();
        $complaints = Complaint::all();
        foreach($complaints as $complaint){
            $neighborhood = $complaint->neighborhood;
            $truck = $neighborhood->truck;
            $user = $truck->user;
            $drivers[]=$user;
        }
        $drivers = array_map("unserialize", array_unique(array_map("serialize", $drivers)));
        return  response()->json($drivers, 200);
    }

    public function showTrucksWithComplaints(){
        $this->authorize('viewTrucksWithComplaints',Complaint::class);
        $trucks = array();
        $complaints = Complaint::all();
        foreach($complaints as $complaint){
            $neighborhood = $complaint->neighborhood;
            $truck = $neighborhood->truck;
            $trucks[]=$truck;
        }
        $trucks = array_map("unserialize", array_unique(array_map("serialize", $trucks)));
        return  response()->json($trucks, 200);
    }

    public function showNeighborhoodsWithComplaints(){
        $this->authorize('viewNeighborhoodsWithComplaints',Complaint::class);
        $neighborhoods = array();
        $complaints = Complaint::all();
        foreach($complaints as $complaint){
            $neighborhoods[] = $complaint->neighborhood;
        }
        $neighborhoods = array_map("unserialize", array_unique(array_map("serialize", $neighborhoods)));
        return  response()->json($neighborhoods, 200);
    }

    public function store(Request $request){
        $messages= [
            'required'=> 'El campo :attribute es obligatorio.',
        ];
        $request->validate([
            'complaint' =>'required',
            'username' =>'required|string|max:35',
            'email'=>'required|string|max:35',
            'neighborhood_id'=>'required'
        ],$messages);
        $complaint = New Complaint ($request->all());
        $neighborhood = Neighborhood::find($request->get('neighborhood_id'));
        $complaint->truck_id = $neighborhood->truck_id;
        $complaint->state = "Pendiente";
        $complaint->save();
        return response()->json($complaint, 201);
    }

    public function update(Request $request, Complaint $complaint){
        $this->authorize('update',$complaint);
        $complaint ->update($request->all());
        return response()->json($complaint, 200);
    }

    public function delete(Complaint $complaint){
        $this->authorize('delete',$complaint);
        $complaint->delete();
        return response()->json(null, 204);
    }
}
