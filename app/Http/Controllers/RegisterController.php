<?php

namespace App\Http\Controllers;

use App\Events\Register;
use App\Models\User;
use App\Notifications\RegisterNotification;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $regUser = User::first();

        $when = Carbon::now()->addMinute(10);

        $data = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required' 
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $regUser->notify((new RegisterNotification($user))->delay($when));

        event(new Registered($user));

        event(new Register($user));

        $token  = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user'=>$user,
            'token'=>$token,
        ];

        return response($response, 201);
    }
}
