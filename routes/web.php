<?php

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

Route::get('/', function () {

	
	$user = App\User::find(array_get($_COOKIE, 'user_id'));

	$users = App\User::with(['following'])->get();

    return view('users', [
    	'users' => $users,
    	'current_user' => $user
    ]);
});

Route::post('/', function () {

	$user = App\User::find(array_get($_COOKIE, 'user_id'));
	
	$follow_user = App\User::findOrFail(Request::get('user_id'));

	if (! $user->following->contains($follow_user->id)) {
	    $user->following()->save($follow_user);
	}

	return response()->json([
	    'following' => $follow_user->id,
	]);
});

Route::post('/unfollow', function () {

	$user = App\User::find(array_get($_COOKIE, 'user_id'));
	
	$follow_user = App\User::findOrFail(Request::get('user_id'));

	if ( $user->following->contains($follow_user->id)) {
	    $user->following()->detach($follow_user->id);
	}

	return response()->json([
	    'unfollowed' => $follow_user->id,
	]);
});


