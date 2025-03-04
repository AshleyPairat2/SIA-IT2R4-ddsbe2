<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use DB;

class UserController extends Controller
{
    use ApiResponseTrait; // Add the trait

    private $request;

    public function getUsers()
    {
        $users = User::all();
        return $this->successResponse($users, "Users retrieved successfully");
    }

    public function index()
    {
        $users = User::all();
        return $this->successResponse($users);
    }

    public function add(Request $request){
        $rules = [
            'username' => 'required|max:20',
            'password' => 'required|max:20',
            'gender' => 'required|in:Male,Female',
        ];

        $this->validate($request,$rules);

        $user = User::create($request->all());

        return $this->successResponse($user, Response::HTTP_CREATED);
    }
    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return $this->errorResponse("User not found", 404);
        }

        return $this->successResponse($user, "User found");
    }

    public function update(Request $request, $id)
{
    $rules = [
        'username' => 'max:20',
        'password' => 'max:20',
        'gender' => 'in:Male,Female',
    ];
    $this->validate($request, $rules);

    $user = User::findOrFail($id);
    $user->fill($request->all());

    if ($user->isClean()) {
        return response()->json(['error' => 'At least one value must change'], 422);
    }

    $user->save();
    return response()->json($user);
}

public function delete($id)
{
    $user = User::findOrFail($id);
    $user->delete();
    return response()->json(['message' => 'User deleted successfully']);
}

}