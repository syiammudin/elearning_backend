<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index(Request $request)
    {

        $kelas = Kelas::when($request->search, function ($q) use ($request) {
            $q->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%");
            });
        });
        if ($request->type == 'list') {
            return $kelas->where('status', true)->get();
        } else {
            return $kelas->orderBy($request->sort, $request->order == 'descending' ? 'desc' : 'asc')->paginate($request->pageSize);
        }
    }


    public function store(Request $request)
    {
        $request['user_id'] = auth()->user()->id;
        $data = Kelas::create($request->all());
        return ['message' => 'Data has been saved', 'data' => $data];
    }

    public function show($id)
    {
        $kelas = Kelas::find($id);
        return $kelas;
    }

    public function update(Request $request, $id)
    {
        $kelas = Kelas::find($id);
        $kelas->update($request->all());
        return ['message' => 'Data has been updated', 'data' => $kelas];
    }


    public function destroy($id)
    {
        $kelas = Kelas::find($id);
        $kelas->delete();
        return ['message' => 'Data has been deleted'];
    }
}
