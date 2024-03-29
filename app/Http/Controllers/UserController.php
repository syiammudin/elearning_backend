<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {

        $user = User::orderBy($request->sort, $request->order == 'descending' ? 'desc' : 'asc')
            ->when($request->user == 'siswa', function ($q) {
                return $q->where('role', User::SISWA);
            });

        return $user->paginate($request->pageSize);
    }

    public function store(UserRequest $request)
    {
        $data = User::create($request->all());


        return ['message' => 'Data has been save', 'data' => $data];
    }

    public function show(User $user)
    {
        return $user;
    }

    public function update(Request $request, User $user)
    {
        $user->update($request->all());
        return ['message' => 'Data has been Updated', 'data' => $user];
    }

    public function destroy(User $user)
    {
        $user->delete();
        return ['message' => 'Data has been deleted'];
    }
}
