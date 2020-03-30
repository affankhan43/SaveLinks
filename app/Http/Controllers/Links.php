<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Links extends Controller
{
    public function Categories($id){
        return DB::table("categories")->where("tokenId",$id)->get();
    }

    public function Authenticate($id){
        $tokenInfo =  DB::table("tokens")->where("token",$id)->first();
        if($tokenInfo != null){
            return view("welcome",["info" => $tokenInfo]);
        }else{
            return view("error");
        }
    }

    public function SaveCategory(Request $request){
       $isAlreadyRegistered = DB::table("categories")->where("name",$request->newName)->where("tokenId",$request->tokenId)->count();
       if(!$isAlreadyRegistered){
        $catId = DB::table("categories")->insertGetId(["name" => $request->newName,"tokenId" => $request->tokenId,"created_at" => date("Y-m-d h:i:s"),"updated_at" => date("Y-m-d h:i:s")]);
        return ["response" => $catId];
        }else{
            return ["response" => "Already Exists"];
       }
    }

    public function EditCategory(Request $request){
        $data = ["name" => $request->name,"updated_at" => date("Y-m-d h:i:s")];

       $count = DB::table("categories")->where("name",$request->name)->where("tokenId",$request->tokenId)->count();

       if($count >= 1){
        return ["response" => "Error"];
       
       }else{
         DB::table("categories")->where("id",$request->id)->update($data);
         return ["response" => "Category updated successfully"];
       }
    }

    public function RemoveLink($linkId){
        DB::table("links")->delete($linkId);
        return ["response" => "Deleted successfully"];
    }



    public function SaveLink(Request $request){
      if(preg_match("@^http://@i",$request->url) || preg_match("@^https://@i",$request->url)){
        $url = $request->url;
      }else{
        $url = 'http://'.$request->url;
      }
      $info = [
          "url" => $url,
          "tags" => $request->tags,
          "cat_id" => $request->cat_id,
          "created_at" => date("Y-m-d h:i:s"),
          "updated_at" => date("Y-m-d h:i:s"),
          "tokenId" => $request->tokenId
        ];

      $count =  DB::table("links")->where("url",$url)->where("tokenId",$request->tokenId)->count();

      if($count >= 1){
          return ["response" => "Error"];
      }

       $id = DB::table("links")->insertGetId($info);
       return ["response" => $id];
    }

    public function SaveLinkChanges(Request $request){
       $isAvailable = DB::table("links")->where("url",$request->url)->where("tokenId",$request->tokenId)->count();
       if($isAvailable){
           return ["response" => "Error"];
       }else{
           $data = [
               "url" => $request->url,
               "tags" => $request->tags,
               "updated_at" => date("Y-m-d h:i:s")
           ];
           DB::table("links")->where("id",$request->id)->update($data);
           return ["response" => "Success"];
       }
    }

    public function OldLinks($id){
        return DB::table("links")->where("tokenId",$id)->get();
    }

    public function RemoveCategory($id){
      $categoryInfo =  DB::table("categories")->where("name",$id)->first();
      DB::table("links")->where("cat_id",$categoryInfo->id)->delete();
      DB::table("categories")->where("id",$categoryInfo->id)->delete();
      return ["response" => "Category and all its data deleted"];
    }
}
