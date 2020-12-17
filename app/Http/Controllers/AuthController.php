<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register(Request $request): \Illuminate\Http\JsonResponse
    {
        $this->validateUserData($request);
        $request['password'] = Hash::make($request->get('password'));
        try {
            $user = User::create($request->toArray());
            return response()->json(['user' => $user], Response::HTTP_CREATED);
        } catch (\Exception $exception) {
            return response()->json(['message' => 'Registration failed'], Response::HTTP_CONFLICT);
        }
    }

    public function signIn(Request $request): \Illuminate\Http\JsonResponse
    {
        $this->validateUserData($request);
        $credentials = $request->only(['email', 'password']);

        if (! $token = Auth::attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }

        return response()->json(['token' => $token], Response::HTTP_OK);
    }

    public function recoverPassword(Request $request): \Illuminate\Http\JsonResponse
    {
        $this->validateUserData($request);
        Auth::user()->update([
            'password' => Hash::make($request->get('password'))
        ]);
        return response()->json([
            'message' => 'Password has been updated'
        ], Response::HTTP_OK);
    }

    private function validateUserData($request)
    {
        $uniq = $request->is('api/user/register') ? '|unique:users' : '';
        $this->validate($request, [
           'email' => 'required|email' . $uniq,
           'password' => 'required|min:6'
        ]);
    }
}
