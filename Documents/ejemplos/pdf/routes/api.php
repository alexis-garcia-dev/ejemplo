<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PdfController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


///store(Request $request)

Route::post('/user/store', [PdfController::class, 'store']);

//excel()
Route::get('/generate/excel', [PdfController::class, 'excel']);

//pdf()
Route::get('/generate/pdf', [PdfController::class, 'pdf']);


//excel2()
Route::get('/generate/excel2', [PdfController::class, 'excel2']);
