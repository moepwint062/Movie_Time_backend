<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Home\BusSchedule;
use App\Models\Home\Todolist;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class BusScheduleController extends Controller
{
    public function index()
    {
        $today = Carbon::now()->format('Y-m-d');
        // $today = '2022-08-31';

        $busSchedule = BusSchedule::where('date', $today)->get();
        return response()->json([
            'result' => true, 
            'data' => [
                'busSchedule' => $busSchedule
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
            'bus_time' => 'required'
        ]);

        // $today = Carbon::now()->format('Y-m-d');
        $today = '2022-08-31';

        if($request['bus_time'] != "undefined:undefined") {
            $walking_time = Todolist::where('date', '=', $today)->value('walking_time');
            $existedDate = BusSchedule::where('date', '=', $today)->orderBy('id', 'ASC')->first();
            if($existedDate == NULL) {
                if(substr($request->input('bus_time'),0,2) >= substr($walking_time,0,2)) {
                    if(substr($request->input('bus_time'),2) >= substr($walking_time,2)) {
                        $busTime = new BusSchedule();
                        $busTime->date = $today;
                        $busTime->bus_time = $request->input('bus_time');
                        $busTime->time_to_cinema = $request->input('time_to_cinema');
                        $busTime->save();
                    } else {
                        return response()->json(['result' => false, 'message' => "Wrong time set up!"]);
                    }
                } else {
                    return response()->json(['result' => false, 'message' => "Wrong time set up!"]);
                }
            } else {
                return response()->json(['result' => false, 'message' => "Today schedule is already set up!"]);
            }
        } else {
            return response()->json(['result' => false, 'message' => "Please type bus setup time!"]);
        }
        
        return response()->json(['result' => true, 'message' => "Bus schedule is saved."]);
    }
}
