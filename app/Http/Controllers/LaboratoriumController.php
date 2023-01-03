<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\Laboratorium;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaboratoriumController extends Controller
{
    public function index(Request $request)
    {
        return Laboratorium::with(['user', 'attachment'])->paginate($request->pageSize);
    }

    public function store(Request $request)
    {
        $data = DB::transaction(function () use ($request) {
            $request['user_id'] = auth()->user()->id;
            $data = Laboratorium::create($request->all());
            $datafix = $data->load('category');

            if ($request->attachment) {
                $data->Attachment()->create($request->attachment);
            }

            $sb = [
                'descryption' => $request->description,
                'tag' => $datafix->category ? $datafix->category->name : $request->type,
                'title' => $request->title,
                'url' => env('SANCTUM_STATEFUL_DOMAINS') . '/laboratorium/' . $data->id,
            ];
            $data->SearchBox()->create($sb);
            $data->History()->create($request->all());

            return $data;
        });

        return ['message' => 'data has been saved', 'data' => $data];
    }

    public function show(Laboratorium $laboratorium)
    {
        return $laboratorium->load(['attachment', 'rating', 'comment']);
    }

    public function update(Request $request, Laboratorium $laboratorium)
    {
        $data = DB::transaction(function () use ($request,  $laboratorium) {
            $laboratorium->update($request->all());

            $cek = Attachment::where('attachable_id', $laboratorium->id)->where('attachable_type', Laboratorium::class);
            if ($cek->count() == 1) {
                $attachment = [
                    'name' => $request->attachment['name'],
                    'path' => $request->attachment['path'],
                    'size' => $request->attachment['size'],
                    'mime' => $request->attachment['mime'],
                ];
                $cek->update($attachment);
            } else {
                $laboratorium->Attachment()->create($request->attachment);
            }

            $request['user_id'] = auth()->user()->id;
            $request['remark'] = 'Update';
            $laboratorium->History()->create($request->all());

            return $laboratorium;
        });

        return ['message' => 'data has been updated', 'data' => $data];
    }

    public function destroy(Laboratorium $laboratorium)
    {
        $laboratorium->delete();
        return ['message' => 'data has been delete'];
    }
}
