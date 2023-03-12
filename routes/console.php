<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('create:user {name} {email}', function($name, $email) {
    $this->info("Creating user with name: $name and email: $email");

    $user = User::create([
        'name'     => $name,
        'email'    => $email,
        'password' => Hash::make('password'),
    ]);

    $this->info("User created with id: $user->id");
})->purpose('Create a new user');