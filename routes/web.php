<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function (Request $request) {
    return redirect('/home');
});
// public\assets\images\logo.webp
Route::get('/{any}', function ($any) {
    if (strpos($any, 'admin/') === 0) {
        return view('layouts.admin');
    } else if (strpos($any, 'assets/') === 0 || strpos($any, 'storage/') === 0) {
        return response()->file(public_path($any));
    }
    return view('layouts.app');
})->where('any', '^(?!api\/)[\/\w\.-]*');
