<?php

/**
 * Description of AuthController
 *
 * @author Ansel Melly <ansel@anselmelly.com> @anselmelly
 * @date Apr 1, 2024
 * @link https://anselmelly.com
 * 
 */

namespace App\Http\Controllers\API;

use App\{
    Http\Controllers\Controller,
    Models\User
};
use Illuminate\{
    Http\JsonResponse,
    Http\Request,
    Support\Facades\Auth,
    Support\Facades\Hash,
    Support\Facades\Validator
};
use function auth;
use function response;

class AuthController extends Controller
{

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Get a JWT token for the user.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
                    'email' => ['required', 'string', 'email', 'max:255'],
                    'password' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $credentials = request(['email', 'password']);

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated user.
     *
     * @return JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out and invalidate the token.
     *
     * @return JsonResponse
     */
    public function logout()
    {
        Auth::logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh the JWT token.
     *
     * @return JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(Auth::refresh());
    }

    /**
     * Respond with the token data.
     *
     * @param  string  $token
     * @return JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
                    'access_token' => $token,
                    'token_type' => 'bearer',
                    'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
                    'name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                    'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
        ]);
        if ($user) {
            $user->assignRole('user');
        }

        return response()->json(['message' => 'User registered successfully'], 201);
    }
    
}
