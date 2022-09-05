<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Home\BusSchedule;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class MovieTimeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $movieLists = ["10:00", "12:30", "15:30", "18:30"];

        $today = Carbon::now()->format('Y-m-d');
        // $today = '2022-08-31';

        $catchUpTime = BusSchedule::join('todolists', 'todolists.date', '=', 'bus_schedules.date')
                    ->where('bus_schedules.date', $today)
                    ->where('todolists.date', $today)
                    ->value('bus_schedules.time_to_cinema');
        
        foreach ($movieLists as $movies) {
            if(substr($catchUpTime, 0, 2) <= substr($movies, 0, 2)) {
                $movieCatch = $movies;

                switch ($movieCatch) {
                    case "10:00":
                        $movieTime = "10:00 AM";
                        break;
                    case "12:30":
                        $movieTime = "12:30 PM";
                        break;
                    case "15:30":
                        $movieTime = "3:30 PM";
                        break;
                    case "18:30":
                        $movieTime = "6:30 PM";
                        break;
                }
                return response()->json(['result' => true, 'data' => ['movieTime' => $movieTime]]);
            }
            
        }
    }
}

