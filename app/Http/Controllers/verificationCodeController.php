<?php

namespace App\Http\Controllers;

use App\Traits\verification_code;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class verificationCodeController extends Controller
{
    //
    use verification_code;

    ################# Verify verification code and change status ######################
    public function check_verification_code(Request $request){
        $validate = Validator::make($request->all(), [
            'code' => 'required',
        ]);
        if ($validate->fails()) {
            return $this->handelError($validate->errors(),422);
        }
        $user=auth('sanctum')->user();
        if ($request->code==$user->verification_code) {
            $user->status='Active';
            $user->verification_code=null;
            $user->save();
            return $this->handelResponse('','Verification code is correct User activated');
        }else{
            return $this->handelError(["code"=>'Invalid verification code'],422);
        }
    }

    ################# Resend verification code ######################

    public function Resend_verification_code(){
        $user=auth('sanctum')->user();
        $code=rand(1000,9999);
        $user->verification_code=$code;
        $user->save();
        $this->SentCode($code,$user->phone);
        return $this->handelResponse('', 'Verification code has been sent.');


    }
}
