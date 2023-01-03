<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamQuiz;
use App\Models\ExamQuizz;
use App\Models\MasterQuiz;
use App\Models\MasterQuizQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExamController extends Controller
{
    public function index(Request $request)
    {
        $kelas = Exam::when($request->search, function ($q) use ($request) {
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
        $exam = Exam::where('master_quiz_id', $request->id)->where('user_id', auth()->user()->id);



        if ($exam->count() >= 1) {
            return ['message' => 'melanjutkan mengerjakan quiz', 'data' => $exam->first()];
        }


        $data = DB::transaction(function () use ($request) {

            $quiz = MasterQuizQuestion::where('master_quiz_id', $request->id)->inRandomOrder()->limit($request->total_quizzes)->get();
            $request['master_quiz_id'] = $request->id;
            $data = Exam::create($request->all());

            foreach ($quiz as $key => $value) {
                $examQuiz['nomor'] = $key + 1;
                $examQuiz['user_id'] = auth()->user()->id;
                $examQuiz['question'] = $value->question;
                $examQuiz['choices'] = $value->choices;
                $examQuiz['correct_answer'] = $value->correct_answer;
                $examQuiz['user_answer'] = $value->user_answer;
                $examQuiz['exam_id'] = $value->user_answer;
                $examQuiz['path'] = $value->path;

                $data->ExamQuiz()->create($examQuiz);
            }

            $data->ExamUser()->create(['user_id' => auth()->user()->id]);

            return $data;
        });

        return ['message' => 'Data has been save', 'data' => $data];
    }

    public function show(Exam $exam)
    {
        return $exam->load(['ExamQuiz', 'ExamUser', 'MasterQuiz']);
    }

    public function update(Request $request, Exam $exam)
    {
        $data = DB::transaction(function () use ($request, $exam) {
            foreach ($request->exam_quiz as $key => $value) {
                ExamQuiz::find($value['id'])->update(['status' => $value['status']]);
            }
            $correct_answer = ExamQuiz::where('status', true)->count();
            $request['score'] = $correct_answer * (100 / $request->total_quizzes);
            $request['status'] = true;
            if ($request['score'] < $request->passing_grade) {
                # code...
                $request['passed'] = false;
            } else {
                $request['passed'] = true;
            }

            $exam->update($request->all());
            return $exam;
        });

        return ['message' => 'Data has been updated', 'data' => $data];
    }

    public function destroy($id)
    {
        //
    }

    public function saveQuiz(Request $request, $id)
    {
        $data = ExamQuiz::find($id)->update($request->all());

        return ['message' => 'data has been save', 'data' => $data];
    }

    public function updateTime($id)
    {
        $data = Exam::find($id)->update(['max_duration' => 30]);

        return ['message' => 'data has been save', 'data' => $data];
    }
}
