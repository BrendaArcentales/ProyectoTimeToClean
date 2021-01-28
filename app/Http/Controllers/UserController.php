<?php

namespace App\Http\Controllers;


use App\Models\Truck;
use App\Models\User;
use App\Http\Resources\User as UserResource;
use App\Http\Resources\UserCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserController extends Controller
{
    //
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        return response()->json(compact('token'));
    }
    public function register(Request $request){
        $this->authorize('create',User::class);
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'birthdate' => 'required',
            'type' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|string|max:255',
            'cellphone' => 'required',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        $user = User::create([
            'name' => $request->get('name'),
            'lastname' => $request->get('lastname'),
            'birthdate' => $request->get('birthdate'),
            'type' => $request->get('type'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'role' => $request->get('role'),
            'cellphone' => $request->get('cellphone'),
        ]);
        $token = JWTAuth::fromUser($user);
        return response()->json(compact('user','token'),201);
    }
    public function getAuthenticatedUser()
    {

        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }
        return response()->json(new UserCollection(compact('user')),200);
    }
    public function index()
    {
        $this->authorize('viewAny', User::class);
        return new UserCollection(User::paginate(3));
    }
    public function show(User $user){
        $this->authorize('view',$user);
        return response()->json(new UserResource($user),200);
    }
    public function showDriversAlternate(){
        $this->authorize('viewDriversAlternate',User::class);
        $drivers = User::where('type','Suplente')->get();
        return response()->json(new UserCollection($drivers), 200);
    }
    public function showDriversWithoutTruck(User $user){
        $this->authorize('viewDriverswithoutTrucks',User::class);
        $trucks=Truck::all();
        $driver=array();
        foreach ($trucks as $truck){
            if($truck['user_id']!=null)
            $driver[]=$truck['user_id'];
        }
        //dd($driver);
       $users = DB::table("users")->select('*')
            ->whereNotIn('id',$driver)->get();
        return response()->json(new UserCollection($users), 200);
    }
    public function showDriversWithTruck(){
        $this->authorize('viewDriverswithTrucks',User::class);
        $users = DB::table("users")->select('*')
            ->whereIn('id',function($query){
                $query->select('user_id')->from('trucks');
            })->get();

        return response()->json(new UserCollection($users), 200);
    }

    public function update(Request $request, User $user)
    {
        $this->authorize('update',$user);
        $user->update($request->all());
        return response()->json($user,200);
    }
    public function delete(User $user)
    {
        $this->authorize('delete',$user);
        $user->delete();
        return response()->json(null,204);
    }
}
