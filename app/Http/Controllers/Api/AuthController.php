<?php

namespace App\Http\Controllers\Api;

use Symfony\Component\HttpFoundation\Response;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegisterRequest;

use App\Models\User;

use App\Mail\SuccessfulUserRegistrationEmail;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(UserRegisterRequest $request)
    {
        $data = $request->validated();

        DB::transaction(function () use ($data) {
            $user = User::create($data);
            $user->assignRole('user');

            $user->profile()->create(['user_id' => $user->id]);
            $user->cart()->create(['user_id' => $user->id]);
            $user->whishList()->create(['user_id' => $user->id]);

            Mail::to($user->email)->send(new SuccessfulUserRegistrationEmail($user));
        });

        return response()->json([
            'message' => 'Successful registration'
        ], Response::HTTP_CREATED);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email:rfc'],
            'password' => ['required']
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Email or password are wrong'
            ], Response::HTTP_BAD_REQUEST);
        }

        /** @var \App\Models\User */
        $user = Auth::user();

        $token = $user->createToken('token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'token' => $token
        ], Response::HTTP_OK);
    }
}
