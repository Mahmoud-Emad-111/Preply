<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\TeacherFollowingResources;
use App\Models\User;
use App\Traits\verification_code;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PDO;

class UserController extends Controller
{
    use verification_code;
    //
    public function Register(UserRequest $request){

        $code=rand(1000,9999);
        $user=User::create([
            'name'=>$request->name,
            'phone'=>$request->phone,
            'password'=>Hash::make($request->password),
            'verification_code'=>$code,
        ]);

        $this->SentCode($code,$request->phone);

        return $this->handelResponse('', 'Registration has been completed successfully and the verification code has been sent.');

    }

    public function Login(Request $request){
        $validate = Validator::make($request->all(), [
            'phone' => 'required|exists:users,phone|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'password' => 'required|min:8',
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors());
        }

        if (Auth::attempt(['phone' => $request->phone, 'password' => $request->password])) {
            $user = Auth::user();

            if($user->verification_code==null){
                $response = [
                    'name' => $user->name,
                    'token' => $user->createToken($user->phone)->plainTextToken,
                ];
                return $this->handelResponse($response, 'login successfully');

            }else{
                $code=rand(1000,9999);
                $user->verification_code=$code;
                $user->save();
                $this->SentCode($code,$request->phone);
                return $this->handelResponse('', ' the verification code has been sent.',204);

            }

        } else {
            return $this->handelError(['error' => 'unauthorized'], 401);
        }
    }

    public function Profile(){
        return $user=auth('sanctum')->user();

    }

    public function Logout(){

        auth('sanctum')->user()->tokens()->delete();
        return response()->json([
            'message' => 'Completely logout successfully',

        ]);
    }
    #################### Change User Password ##########################

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = auth('sanctum')->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['error' => 'Current password is incorrect.'], 401);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['message' => 'Password changed successfully.'], 200);
    }

    #################### Change User Status (Active,Pending,Rejected) ##########################

    public function ChangeStatus(Request $request){
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:Active,Rejected',
            'id'=>'required|exists:users'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        User::find($request->id)->update([
            'status'=>$request->status
        ]);
        return $this->handelResponse('','Status changed successfully');
    }
    #################### Get All Users ##########################
    public function Get(){
        return User::all();
    }

 
}
