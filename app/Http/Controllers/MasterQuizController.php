<?php

namespace App\Http\Controllers;

use App\Models\MasterQuiz;
use App\Models\MasterQuizQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MasterQuizController extends Controller
{
    public function index(Request $request)
    {

        if (Auth::user()) {
            # code...
            $data = MasterQuiz::when($request->keyword, function ($q) use ($request) {
                return $q->where('subject', 'like', '%' . $request->keyword . '%')
                    ->orWhere('description', 'like', '%' . $request->keyword . '%');
            })->with(['User', 'MasterQuizQuestion'])->when($request->search, function ($q) use ($request) {
                $q->where(function ($q) use ($request) {
                    $q->where('subject', 'like', "%{$request->search}%");
                });
            });

            if (auth()->user()->role_name != 'ADMIN') {
                $data->whereJsonContains('kelas', auth()->user()->kelas);
            }
            return $data->paginate();
        } else {
            $data = MasterQuiz::with(['MasterQuizQuestion'])->when($request->search, function ($q) use ($request) {
                $q->where(function ($q) use ($request) {
                    $q->where('subject', 'like', "%{$request->search}%");
                });
            });

            return $data->paginate();
        }
    }


    public function store(Request $request)
    {
        $data = DB::transaction(function () use ($request) {
            $request['user_id'] = auth()->user()->id;
            $data = MasterQuiz::create($request->all());
            if ($request->master_quiz_question) {
                foreach ($request->master_quiz_question as $value) {
                    $data->MasterQuizQuestion()->create($value);
                }
            }

            $sb = [
                'descryption' => $request->description,
                'tag' => "$request->description $request->title $request->kelas_id",
                'title' => $request->subject,
                'url' => env('SANCTUM_STATEFUL_DOMAINS') . '/video/' . $data->id,
            ];

            $data->SearchBox()->create($sb);

            return $data;
        });

        return ['message' => 'Data has been saved', 'data' => $data];
    }


    public function show(MasterQuiz $masterQuiz)
    {
        return $masterQuiz->load(['MasterQuizQuestion', 'User']);
    }

    public function update(Request $request, MasterQuiz $masterQuiz)
    {
        $data = DB::transaction(function () use ($request, $masterQuiz) {

            $masterQuiz->update($request->all());
            if ($request->master_quiz_question) {
                foreach ($request->master_quiz_question as $value) {
                    if (isset($value['id'])) {
                        $data['choices'] = $value['choices'];
                        $data['correct_answer'] = $value['correct_answer'];
                        $data['mime'] = $value['mime'];
                        $data['name'] = $value['name'];
                        $data['path'] = $value['path'];
                        $data['question'] = $value['question'];
                        $data['size'] = $value['size'];
                        MasterQuizQuestion::find($value['id'])->update($data);
                    } else {
                        $masterQuiz->MasterQuizQuestion()->create($value);
                    }
                }
            }

            return $masterQuiz;
        });

        return ['message' => 'Data has been Updated', 'data' => $data];
    }

    public function destroy(MasterQuiz $masterQuiz)
    {
        $masterQuiz->delete();
        return ['message' => 'Data has been deleted', 'data' => $masterQuiz];
    }
}
