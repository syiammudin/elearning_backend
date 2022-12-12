<?php

namespace App\Http\Controllers;

use App\Models\MasterQuiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MasterQuizController extends Controller
{
    public function index(Request $request)
    {
        $data = MasterQuiz::with('MasterQuizQuestion');

        return $data->paginate();
    }


    public function store(Request $request)
    {
        $data = DB::transaction(function () use ($request) {
            $data = MasterQuiz::create($request->all());
            if ($request->master_quiz_quistion) {
                $data->MasterQuizQuestion()->createMany($request->master_quiz_quistion);
            }

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
            if ($request->master_quiz_quistion) {
                foreach ($request->master_quiz_quistion as $value) {
                    if ($value->id) {
                        $masterQuiz->MasterQuizQuestion()->update($value);
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
