<?php

namespace App\Http\Controllers;

use App\Http\Resources\TeacherFollowingResources;
use App\Models\TeacherFollwers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TeacherFollwersController extends Controller
{
    //
################### Sending a follow-up from a user to a teacher ############
    public function Store(Request $request){
        $validator = Validator::make($request->all(), [
            'id'=>'required|exists:teachers'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $user=auth('sanctum')->user();
        TeacherFollwers::create([
            'user_id'=>$user->id,
            'teacher_id'=>$request->id,
        ]);
        return $this->handelResponse('','The teacher has been successfully Follow');
    }



    public function Unfollow(Request $request){
        $validator = Validator::make($request->all(), [
            'id'=>'required|exists:teachers'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $user=auth('sanctum')->user();
         TeacherFollwers::Where('user_id',$user->id)->where('teacher_id',$request->id)->delete();
        return $this->handelResponse('','The teacher has been unfollowed');
    }

    ################# Get the teachers that the user follows ################
    public function Teacher_Following(){
        $user = auth('sanctum')->user();
        return TeacherFollowingResources::collection($user->teacher)->resolve();
    }
    ########## Get users who follow the teacher ##################
    public function Teacher_Followers(){
         $Teacher = auth('sanctum')->user();
        return $this->handelResponse(['Followers'=>count($Teacher->followers)],'');

    }

}
