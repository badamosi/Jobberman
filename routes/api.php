<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

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

Route::middleware('auth')->get('/user', function (Request $request) {
    switch(Auth::user()->role){
        case 'admin':
            return Auth::user();
            break;
        case 'company':
            return User::with('company')->find(Auth::user()->id);
            break;
    }
});

Route::middleware('auth')->group(function () {

    Route::post('profile/change_password', 'HomeController@changePassword');
    Route::put('profile/update/{id}', 'HomeController@updateProfile');

    Route::resources([
        'company'=>'CompanyController',
        'employee'=>'EmployeeController',
    ]);

});

Route::get('{path}', "HomeController@index")->where('path', '([A-z\d\-\/_.]+)?');