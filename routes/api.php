<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

'Route'::get("allCategories/{id}","Links@Categories");
'Route'::post("saveCategory","Links@SaveCategory");
'Route'::get("removeCategory/{id}","Links@RemoveCategory");
'Route'::post("saveLink","Links@SaveLink");
'Route'::get("fetcholdlinks/{id}","Links@OldLinks");
'Route'::get("removeLink/{id}","Links@RemoveLink");
'Route'::post("editCat","Links@EditCategory");
'Route'::post("updateLink","Links@SaveLinkChanges");
'Route'::get("getFreshToken","Tokens@Generate");
'Route'::post("verifyEmail","Tokens@VerifyEmail");
