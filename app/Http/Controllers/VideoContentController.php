<?php

namespace App\Http\Controllers;

use App\Http\Requests\VideoContentRequest;
use App\Models\Attachment;
use App\Models\Comment;
use App\Models\Rating;
use App\Models\VideoContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VideoContentController extends Controller
{
    public function index(Request $request)
    {
        return VideoContent::with(['user', 'attachment', 'rating'])->orderBy($request->sort, $request->order == 'descending' ? 'desc' : 'asc')->paginate($request->pageSize);
    }


    public function store(VideoContentRequest $request)
    {
        $data = DB::transaction(function () use ($request) {
            $request['user_id'] = auth()->user()->id;
            $request['remark'] = 'Create';
            $data = VideoContent::create($request->all());
            $datafix = $data->load('category');

            if ($request->attachment) {
                $data->Attachment()->create($request->attachment);
            }
            $sb = [
                'descryption' => $request->description,
                'tag' => $datafix->category ? $datafix->category->name : $request->type,
                'title' => $request->title,
                'url' => env('SANCTUM_STATEFUL_DOMAINS') . '/video/' . $data->id,
            ];
            $data->SearchBox()->create($sb);
            $data->History()->create($request->all());

            return $data;
        });

        return ['message' => 'data has been saved', 'data' => $data];
    }

    public function show(VideoContent $videoContent)
    {
        return $videoContent->load(['attachment', 'rating', 'comment']);
    }

    public function update(Request $request, VideoContent $videoContent)
    {
        $data = DB::transaction(function () use ($request,  $videoContent) {
            $videoContent->update($request->all());

            $cek = Attachment::where('attachable_id', $videoContent->id)->where('attachable_type', VideoContent::class);
            if ($cek->count() == 1) {

                $attachment = [
                    'name' => $request->attachment['name'],
                    'path' => $request->attachment['path'],
                    'size' => $request->attachment['size'],
                    'mime' => $request->attachment['mime'],
                ];
                $cek->update($attachment);
            } else {
                $videoContent->Attachment()->create($request->attachment);
            }
            $request['user_id'] = auth()->user()->id;
            $request['remark'] = 'Update';
            $videoContent->History()->create($request->all());

            return $videoContent;
        });

        return ['message' => 'data has been updated', 'data' => $data];
    }

    public function destroy(VideoContent $videoContent)
    {
        $videoContent->delete();
        return ['message' => 'data has been delete'];
    }

    public function RatingVideoContent(Request $request, $id)
    {
        $data = DB::transaction(function () use ($request, $id) {
            $video = VideoContent::with('Rating')->find($id);
            $request['user_id'] = auth()->user()->id;

            $cek_rating = Rating::where('ratingable_id', $id)->where('user_id', auth()->user()->id);
            if ($cek_rating->count() > 0) {
                $cek_rating->update($request->all());
            } else {
                $video->Rating()->create($request->all());
            }

            $rating = Rating::where('ratingable_id', $id)->where('ratingable_type', VideoContent::class);
            $sum = $rating->sum('value');
            $count = $rating->count();
            return $sum / $count;
        });

        return ['message' => 'rating has been save', 'data' => $data];
    }
}
