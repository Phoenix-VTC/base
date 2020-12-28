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

// Start of lihis/ets2-job-logger API testing routes
Route::match(array('GET', 'POST'),'/', function (Request $request, Response $response) {
    Log::info('app.home', ['request' => $request->all(), 'response' => $response]);
    return response(null, 200);
});

Route::match(array('GET', 'POST'),'v1/capabilities', function (Request $request) {
    Log::info('app.capabilities', ['request' => $request->all()]);
    return response()->json([
        'truck' => true,
        'fine' => true,
    ]);
});

Route::match(array('GET', 'POST'),'v1/job', function (Request $request) {
    Log::info('app.job', ['request' => $request->all()]);
    return response(null, 200);
});

Route::match(array('GET', 'POST'),'v1/truck', function (Request $request, Response $response) {
    Log::info('app.truck', ['request' => $request->all(), 'response' => $response]);
    return response(null, 200);
});

Route::match(array('GET', 'POST'),'v1/fine', function (Request $request) {
    Log::info('app.fine', ['request' => $request->all()]);
    return response(null, 200);
});
// End of lihis/ets2-job-logger API testing routes
