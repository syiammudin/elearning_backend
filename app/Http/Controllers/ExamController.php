<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamQuiz;
use App\Models\ExamQuizz;
use App\Models\ExamSection;
use App\Models\MasterQuiz;
use App\Models\MasterQuizQuestion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExamController extends Controller
{
    public function index(Request $request)
    {
        $kelas = Exam::with(['ExamQuiz', 'ExamUser', 'MasterQuiz', 'ExamSection', 'User'])->when($request->search, function ($q) use ($request) {
            $q->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%");
            });
        });

        if ($request->type == 'list') {
            return $kelas->where('status', true)->get();
        } elseif ($request->type == 'user') {
            return $kelas->where('user_id', auth()->user()->id)->paginate($request->pageSize);
        } else {
            return $kelas
                ->when(isset($request->sort), function ($query) use ($request) {
                    if ($request->sort == 'master_quiz.subject') {
                        $query->orderBy(
                            MasterQuiz::select('subject')->whereColumn('master_quizzes.id', 'exams.master_quiz_id'),
                            $request->order == 'descending' ? 'desc' : 'asc'
                        );
                    } else if ($request->sort == 'user.name') {
                        $query->orderBy(
                            User::select('name')->whereColumn('users.id', 'exams.user_id'),
                            $request->order == 'descending' ? 'desc' : 'asc'
                        );
                    } else {
                        $query->orderBy($request->sort, $request->order == 'descending' ? 'desc' : 'asc');
                    }
                })
                ->paginate($request->pageSize);
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
            $request['user_id'] = auth()->user()->id;
            $request['sisa_durasi'] = $request->max_duration * 60;
            $request['start_time'] = date('Y-m-d');

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
        return $exam->load(['ExamQuiz', 'ExamUser', 'MasterQuiz', 'ExamSection']);
    }

    public function update(Request $request, Exam $exam)
    {
        $data = DB::transaction(function () use ($request, $exam) {
            foreach ($request->exam_quiz as $key => $value) {
                ExamQuiz::find($value['id'])->update(['status' => $value['status']]);
            }

            $correct_answer = ExamQuiz::where('exam_id', $exam->id)->where('status', true)->count();
            $request['score'] = $correct_answer * (100 / $request->total_quizzes);
            $request['status'] = true;
            if ($request['score'] < $request->passing_grade) {
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

    public function updateTime(Request $request, $id)
    {

        $data = Exam::find($id);
        // $examSection = ExamSection::where('exam_id', $data->id)->first();
        // $second = strtotime(date('Y-m-d H:i:s')) - strtotime($examSection->start_section);
        // $sisa_durasi = $data->sisa_durasi - $second;
        $data->update(['sisa_durasi' => $request->sisa_durasi]);


        return ['message' => 'data has been save', 'data' => $data];
    }

    public function sectionExam($id)
    {

        $exam = Exam::find($id);

        $section = ExamSection::where('exam_id', $exam->id)->count() + 1;
        $data['start_section'] = date('Y-m-d H:i');
        $data['section'] = $section;
        $data['user_id'] = auth()->user()->id;
        $exam->ExamSection()->create($data);

        return ['message' => 'data hasbeen saved', 'data' => $exam];
    }
}
