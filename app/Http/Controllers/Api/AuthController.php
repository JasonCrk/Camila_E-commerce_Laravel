<?php

namespace App\Http\Controllers\Api;

use Symfony\Component\HttpFoundation\Response;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegisterRequest;

use App\Models\User;

use App\Mail\SuccessfulUserRegistrationEmail;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['register', 'login']);
    }

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

        if (!$token = auth()->attempt($credentials)) {
            return response()->json([
                'message' => 'Email or password are wrong'
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
            'token_type' => 'bearer',
            'expire_in' => Auth::factory()->getTTL() * 60
        ], Response::HTTP_OK);
    }
}
