<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome', [
    'greeting' => 'Hello, World!',
    'name' => 'John Doe',
    'age' => 30,
    'tasks' => [
        'Learn Laravel',
        'Build a project',
        'Deploy to production',
    ],
]);

Route::view('/about', 'about');
Route::view('/contact', 'contact');

Route::get('/formtest', function(){
    $emails = session()->get('emails', []);

    return view('formtest',[
        'emails' => $emails,
    ]);
});

Route::post('/formtest', function(){
    request()->validate([
        'email'=> 'required|email'
    ]);

    $email = request('email');

    $emails = session()->get('emails', []);

    if(count($emails) >= 5){
        return redirect('/formtest')->with('error','Cannot add more than 5 emails!');
    }

    if (in_array($email, $emails)) {
    return redirect('/formtest')->with('error', 'Email already exists!');
}

    $emails[] = $email;
    session(['emails' => $emails]);

    return redirect('/formtest')->with('success', 'Email added!');
});

Route::get('/delete-emails', function(){
    session()->forget('emails');
    return redirect('/formtest');
});

Route::post('/delete-email/{index}', function($index) {
    $emails = session()->get('emails', []);

    if(isset($emails[$index])) {
        unset($emails[$index]);
        $emails = array_values($emails); // re-index array
        session(['emails' => $emails]);
    }

    return redirect('/formtest')->with('success', 'Email deleted!');
});