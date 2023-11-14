<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateUserReqquest;
use App\Http\Resources\UserResource;
use App\Models\User;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate();

        return UserResource::collection($users);
    }

    public function store(StoreUpdateUserReqquest $request)
    {
        $data = $request->validated();
        $data['password'] = bcrypt($request->password);

        $user = User::create($data);

        return new UserResource($user);
    }

    public function show($id)
    {
        //forma 1
        // $user = User::where('id', '=', $id)->first(); 

        // if(!$user) {
        //     return response()->json(['message' => 'User not found'], 404);
        // }

        // //forma 2
        // $user = User::find($id); 

        // if(!$user) {
        //     return response()->json(['message' => 'User not found'], 404);
        // }

          //forma 3
          $user = User::findOrFail($id);

          return new UserResource($user);

    }

    public function update(StoreUpdateUserReqquest $request, $id)
    {
        
        $user = User::findOrFail($id);

        $data = $request->all();
        $data['password'] = bcrypt($request->password);
        $user->update($data);

        return new UserResource($user);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
