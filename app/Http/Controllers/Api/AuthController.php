<?php

namespace App\Http\Controllers\Api;

use Symfony\Component\HttpFoundation\Response;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegisterRequest;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

use App\Models\User;

use App\Mail\SuccessfulUserRegistrationEmail;

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
}
