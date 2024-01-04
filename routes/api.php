<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/webhook/payment/zoop', [\App\Http\Controllers\ApiController::class, 'logWebHook']) ;
Route::post('/buyer/create', [\App\Http\Controllers\ApiController::class, 'createBuyer']) ;
Route::post('/buyer/card', [\App\Http\Controllers\ApiController::class, 'cardBuyer']) ;
Route::post('/buyer/pay', [\App\Http\Controllers\ApiController::class, 'payCard']) ;

Route::post('/payment', function (Request $request) {
    return response()->json([
        "amount" => "1",
        "max_installments" => 3,
        "seller_id" => "7f998395e5de4f2aa700d46d8079cbcd"
    ]) ;
}) ;

Route::post('/auth', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'device_name' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    return response()->json([
        'token' => $user->createToken($request->device_name)->plainTextToken,
        'name' => $user->name,
        'seller_id' => $user->seller_id,
    ]);
});
