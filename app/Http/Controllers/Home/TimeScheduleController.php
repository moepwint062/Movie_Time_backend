<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Home\Todolist;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class TimeScheduleController extends Controller
{
    public function index()
    {
        // $today = Carbon::now()->format('Y-m-d');
        $today = '2022-08-31';

        $todolist = Todolist::where('date', $today)->get();
        return response()->json([
            'result' => true, 
            'data' => [
                'todoList' => $todolist
            ]
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'alarm' => 'required',
            'time_to_teeth' => 'required',
            'breakfast_time' => 'required',
        ]);

        $today = Carbon::now()->format('Y-m-d');
        // $today = '2022-08-31';

        // Log::info($request);
        if($request['alarm'] != "undefined:undefined" || $request['time_to_teeth' != "undefined:undefined" || $request['breakfast_time'] != "undefined:undefined"]) {
            $existedDate = Todolist::where('date', '=', $today)->orderBy('id', 'ASC')->first();
            if($existedDate == NULL) {
                if(substr($request->input('time_to_teeth'),0,2) >= substr($request->input('alarm'),0,2) && substr($request->input('breakfast_time'),0,2) >= substr($request->input('time_taken_after_teeth'),0,2)) {
                    if(substr($request->input('time_to_teeth'),2) >= substr($request->input('alarm'),2) && substr($request->input('breakfast_time'),2) >= substr($request->input('time_taken_after_teeth'),2)) {
                        $todolist = new Todolist();
                        $todolist->date = $today;
                        $todolist->alarm = $request->input('alarm');
                        $todolist->time_to_teeth = $request->input('time_to_teeth');
                        $todolist->time_taken_after_teeth = $request->input('time_taken_after_teeth');
                        $todolist->breakfast_time = $request->input('breakfast_time');
                        $todolist->time_taken_after_breakfast = $request->input('time_taken_after_breakfast');
                        $todolist->walking_time = $request->input('walking_time');
                        $todolist->save();
                        // Log::info($todolist);
                    } else {
                        return response()->json(['result' => false, 'message' => "Can't set up time to teeth and bath before Alarm!\nYour need 15 mins to bath and teeth and 15 mins to have breakfast!"]);
                    }
                } else {
                    return response()->json(['result' => false, 'message' => "Can't set up time to teeth and bath before Alarm!\nYour need 15 mins to bath and teeth and 15 mins to have breakfast!"]);
                }
            } else {
                return response()->json(['result' => false, 'message' => "Today schedule is already set up!"]);
            }
        } else {
            return response()->json(['result' => false, 'message' => "Please type all setup time!"]);
        }
        
        return response()->json(['result' => true, 'message' => "Schedules are saved."]);
    }
}
