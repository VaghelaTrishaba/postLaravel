<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\pageController;

/*
 route get function return view folder file 
 in url desplay Post and open post file from view

*/

//Route::view('post','/post');   first file name second route name 

Route::get('/',function(){return view('welcome');});

Route::get('/Post/{id?}',function($id = null){
    if($id == null){
    return view('post');
    }
    else{
        return "<h1>Your Post Id : ".$id." </h1>";
    }
})->whereNumber('id');  // only number in id 

//  ->whereIn('id',['view','comment',like])   only enter view ,comment,like

Route::get('/Post/view',function(){
    return view('totalview');   
})->name('myviews');    // give name of route


Route::controller(pageController::class)->group(
    function (){
        Route::get('/','showLogin');
        Route::get('/view','showPost');
        Route::get('/about','showAbout');
        Route::get('/home','showHome');    
    }
); 

Route::view('allposts','allposts');
Route::view('addpost','addpost');

Route::redirect('/aboutUs','/about');

Route::fallback(function(){
    return "Enter Valid Route Name";
});