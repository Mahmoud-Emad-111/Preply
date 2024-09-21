<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\User;
use App\Traits\verification_code;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class verificationCodeController extends Controller
{
    //
    use verification_code;

    ################# Verify verification code user and change status ######################
    public function check_verification_code_User(Request $request){
        $validate = Validator::make($request->all(), [
            'code' => 'required',
            'phone' => 'required|exists:users,phone|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
        ]);
        if ($validate->fails()) {
            return $this->handelError($validate->errors(),422);
        }

         $user= User::Where('phone',$request->phone)->first();
        //  $user=User::find($id)[0];
        if ($request->code==$user->verification_code) {
            $user->verification_code=null;
            $user->save();
            $response['token'] = $user->createToken($user->phone)->plainTextToken;
            return $this->handelResponse($response,'Verification code is correct User activated');
        }else{
            return $this->handelError(["code"=>'Invalid verification code'],422);
        }
    }


    ################# Resend verification code to user ######################

    public function Resend_verification_code_user(Request $request){
        $validate = Validator::make($request->all(), [
            'phone' => 'required|exists:users,phone|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
        ]);
        if ($validate->fails()) {
            return $this->handelError($validate->errors(),422);
        }
        $code=rand(1000,9999);
         $user=User::where('phone',$request->phone)->update([
            'verification_code'=>$code,
         ]);
        // $user->verification_code=$code;
        // $user->save();
        $this->SentCode($code,$request->phone);
        return $this->handelResponse('', 'Verification code has been sent.');
    }





    ################# Verify verification code user and change status ######################
    public function check_code_Teacher(Request $request){
        $validate = Validator::make($request->all(), [
            'code' => 'required',
            'phone' => 'required|exists:teachers,phone|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
        ]);
        if ($validate->fails()) {
            return $this->handelError($validate->errors(),422);
        }

        $Teacher=Teacher::Where('phone',$request->phone)->first();
        if ($request->code==$Teacher->verification_code) {
            $Teacher->verification_code=null;
            $Teacher->save();
            $response['token'] = $Teacher->createToken($Teacher->phone)->plainTextToken;
            return $this->handelResponse($response,'Verification code is correct Teacher activated');
        }else{
            return $this->handelError(["code"=>'Invalid verification code'],422);
        }
    }





    ################# Resend verification code to Teacher ######################

    public function Resend_code_Teacher(Request $request){
        $validate = Validator::make($request->all(), [
            'phone' => 'required|exists:teachers,phone|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
        ]);
        if ($validate->fails()) {
            return $this->handelError($validate->errors(),422);
        }
        $Teacher=Teacher::Where('phone',$request->phone)->first();
        $code=rand(1000,9999);
        $Teacher->verification_code=$code;
        $Teacher->save();
        $this->SentCode($code,$Teacher->phone);
        return $this->handelResponse('', 'Verification code has been sent.');
    }
}
