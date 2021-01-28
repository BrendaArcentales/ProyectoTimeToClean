<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Complaint extends Model
{
    use HasFactory;
    protected $fillable = [
        'complaint',
        'username',
        'email',
        'state',
        'observation',
        'neighborhood_id',
        'truck_id'
    ];

    public function neighborhood(){
        return $this->belongsTo('App\Models\Neighborhood');
    }
}
