<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeacherRegisterRequests;
use App\Http\Resources\TeacherProfileResource;
use App\Models\Teacher;
use App\Traits\SaveFile;
use App\Traits\verification_code;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class TeacherController extends Controller
{
    use SaveFile,verification_code;
    //
    public function Register(TeacherRegisterRequests $request){
        $code=rand(1000,9999);
        $image=$this->saveFile($request->image,'Teachers_Images');
        $video=$this->saveFile($request->video,'Teachers_Videos');
        Teacher::create([
            'name'=>$request->name,
            'country'=>$request->country,
            'description'=>$request->description,
            'subject'=>$request->subject,
            'image'=>$image,
            'video'=>$video,
            'CostHour'=>$request->CostHour,
            'phone'=>$request->phone,
            'password'=>Hash::make($request->password),
            'verification_code'=>$code,

        ]);
        $this->SentCode($code,$request->phone);
        return $this->handelResponse('', 'Registration has been completed successfully and the verification code has been sent.');

    }

    public function Login(Request $request){
        $validate = Validator::make($request->all(), [
            'phone' => 'required|exists:teachers,phone|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'password' => 'required|min:8',
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors());
        }

        if (Auth::guard('Teacher')->attempt(['phone' => $request->phone, 'password' => $request->password])) {
            $teacher = Auth::guard('Teacher')->user();

            if($teacher->verification_code==null){
                $response = [
                    'name' => $teacher->name,
                    'token' => $teacher->createToken($teacher->phone)->plainTextToken,
                ];
                return $this->handelResponse($response, 'login successfully');

            }
            else{
                $code=rand(1000,9999);
                $teacher->verification_code=$code;
                $teacher->save();
                $this->SentCode($code,$request->phone);
                return $this->handelResponse('', ' the verification code has been sent.',204);

            }

        }
         else {
            return $this->handelError(['error' => 'unauthorized'], 401);
        }
    }

    public function Profile(){
        return TeacherProfileResource::make(auth('sanctum')->user())->resolve();

    }

    #################### Change Teacher Password ##########################

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $Teacher = auth('sanctum')->user();

        if (!Hash::check($request->current_password, $Teacher->password)) {
            return response()->json(['error' => 'Current password is incorrect.'], 401);
        }

        $Teacher->password = Hash::make($request->new_password);
        $Teacher->save();

        return response()->json(['message' => 'Password changed successfully.'], 200);
    }


    public function Logout(){

        auth('sanctum')->user()->tokens()->delete();
        return response()->json([
            'message' => 'Completely logout successfully',

        ]);
    }


    #################### Get All Teachers ##########################
    public function Get(){
        return TeacherProfileResource::collection(Teacher::all())->resolve();
    }


    #################### Change Teacher Status (Active,Rejected) ##########################

    public function ChangeStatus(Request $request){
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:Active,Rejected',
            'id'=>'required|exists:teachers'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        Teacher::find($request->id)->update([
            'status'=>$request->status
        ]);
        return $this->handelResponse('','Status changed successfully');
    }
}
