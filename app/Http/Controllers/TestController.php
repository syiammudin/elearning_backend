<?php

namespace App\Http\Controllers;

use App\Models\ExamSection;
use App\Models\MasterQuiz;
use App\Models\VideoContent;
use DateTime;
use Illuminate\Http\Request;

class TestController extends Controller
{

    public function index()
    {
        return MasterQuiz::whereJsonContains('kelas', '531146b3-9c22-43b9-a17c-f91e48c66be5')->get();

        $date1 = ExamSection::first()->start_section;
        $date2 = date('Y-m-d H:i:s');


        $second = strtotime($date2) - strtotime($date1);
        // $sisa_durasi =  

        return 'second ' . $second;

        $Date = "2010-09-17 14:00:00";
        echo date('Y-m-d H:i:s', strtotime($Date . ' + 900 second'));

        return '';
        $date1 = strtotime(date('y-m-d 16:00:00'));
        $date2 = strtotime(date('y-m-d 16:15:00'));

        $second = $date2 - $date1;
        $minutes  = $second / 60;
        return  'in second : ' . $second . ' & in minutes : ' . $minutes;
        return date('y-m-d');
        return VideoContent::with('attachment')->get();
        # code...
    }
    //
}
