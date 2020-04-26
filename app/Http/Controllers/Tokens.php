<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\AuthenticationLink;
class Tokens extends Controller
{
    //
    public function Generate(){
        $token = uniqid();
        $id = DB::table("tokens")->insert(["token" => $token]);
        $data = [
            "id" => $id,
            "token" => $token
        ];
        return redirect()->route('main',['id'=>$token]);
    }

    public function VerifyEmail(Request $request){
       
        
        $tokenInfo = DB::table("tokens")->where("id",$request->input("tokenId"))->first();
         
        

           $data = [];

            if($tokenInfo->email == null){
               $isAvailable = DB::table("tokens")->where("email",$request->email)->first();
               
               if($isAvailable == null){
                     DB::table("tokens")->where("id",$request->tokenId)->update(["email" => $request->email]);
                     Mail::to($request->email)->send(new AuthenticationLink($request->email,$tokenInfo->token));
                      $data["response"] = "Email send successfully and data saved";
                }else{
                   
                     Mail::to($request->email)->send(new AuthenticationLink($request->email,$isAvailable->token));
                     $data["response"] = "Email already exists old link sent to email";
                }
             }

             
            return $data;
        
    }
}
