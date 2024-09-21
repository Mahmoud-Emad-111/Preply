<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\WorkingHours;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WorkingHoursController extends Controller
{
    //

    public function Store(Request $request){
        $validate = Validator::make($request->all(), [
            'day' => 'required|in:Saturday,Sunday,Monday,Tuesday,Wednesday,Thursday,Friday',
            'hour' => 'required',
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors());
        }
        $teacher=auth('sanctum')->user();
        // return $teacher->id;
        WorkingHours::create([
            'day'=>$request->day,
            'hour'=>$request->hour,
            'teacher_id'=>$teacher->id
        ]);

        return $this->handelResponse('','Business times have been added');
    }

    public function Get(){
        $user=auth('sanctum')->user();
        // return Teacher::with('working_hour')->find(1);
        return $user->working_hour;
    }

    public function Update(Request $request){
        $validate = Validator::make($request->all(), [
            'day' => 'required|in:Saturday,Sunday,Monday,Tuesday,Wednesday,Thursday,Friday',
            'hour' => 'required',
            'id'=>'required|exists:working_hours'
        ]);
        if ($validate->fails()) {
            return response()->json($validate->errors());
        }
        $teacher=auth('sanctum')->user();

        WorkingHours::find($request->id)->Update([
            'day'=>$request->day,
            'hour'=>$request->hour,
            'teacher_id'=>$teacher->id
        ]);
        return $this->handelResponse('','Business times have been Updated');

    }

}
