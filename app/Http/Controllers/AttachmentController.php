<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Enums\ModelHelper;

class AttachmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Attachment::get();
    }
    public function store(Request $request)
    {
        $request->validate(['file' => 'required|mimes:mp4,mov,jpg,jpeg,png,docx,pdf,xls,xlsx,doc|max:25000']);
        $fileName = date('ymd_His_') . str_replace(' ', '_', $request->file->getClientOriginalName());
        $name = $request->file->getClientOriginalName();
        $size = $request->file->getSize();
        $mime = $request->file->extension();

        $path = $request->file('file')->move('public/upload/' . $request->type, $fileName);

        $data = [
            'user_id' => auth()->id(),
            'url' => url($path),
            'name' => $name,
            'path' => 'upload/' . $request->type . $fileName,
            'size' => $size,
            'mime' => $mime,
        ];

        return $data;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Attachment $attachment)
    {
        return $attachment;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Attachment $attachment, Request $request)
    {
        $attachment->update($request->all());
        return ['message' => 'Data has been updated', 'data' => $attachment];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attachment $attachment)
    {
        $attachment->delete();
        return ['message' => 'Data has been deleted'];
    }

    public function download(Request $request)
    {
        $attachment = Attachment::where('id', $request->query('hash'))->first();

        if ($attachment) {
            return response()->download(storage_path('/app/' . $attachment->path), $attachment->name);
        }
    }

    public function uploadCkEditor(Request $request)
    {

        $request->validate(['upload' => 'required|mimes:jpg,jpeg,png,docx,pdf,xls,xlsx,doc|max:25000']);
        $fileName = date('ymd_His_') . str_replace(' ', '_', $request->upload->getClientOriginalName());

        $path = $request->file('upload')->move('CkEditor/',  $fileName);

        return ['uploaded' => 1, 'url' => url('CkEditor/' . $fileName), 'fileName' => $fileName];
    }
}
