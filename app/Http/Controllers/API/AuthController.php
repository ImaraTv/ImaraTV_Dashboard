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
    Http\Resources\UsersResources,
    Mail\UserRegistrationEmail,
    Mail\UserResetPasswordEmail,
    Models\PasswordResetToken,
    Models\RegisterToken,
    Models\User
};
use Illuminate\{
    Http\JsonResponse,
    Http\Request,
    Support\Carbon,
    Support\Facades\Auth,
    Support\Facades\DB,
    Support\Facades\Hash,
    Support\Facades\Mail,
    Support\Facades\Validator,
    Support\Str
};
use Google_Client;
use function auth;
use function request;
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

        $user = User::where(['email' => $request->email])->first();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        if (is_null($user->email_verified_at)) {
            return response()->json(['message' => 'user is not verified', 'error' => 'Unverified'], 401);
        }


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
    public function profile()
    {

        return new UsersResources([auth()->guard('api')->user()]);
    }

    /**
     * Log the user out and invalidate the token.
     *
     * @return JsonResponse
     */
    public function logout()
    {
        Auth::guard('api')->logout();

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
                    'url' => ['required', 'string']
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
        $token = Str::random(18);
        (new RegisterToken())
                ->updateOrCreate(['email' => $request->email], ['email' => $request->email, 'token' => $token]);

        // send registration email here... 
        // return the user email
        $url = $request->get('url') . '?token=' . $token . '&email=' . $request->email;
        $mail = new UserRegistrationEmail($url, $user);
        Mail::to($user)->send($mail);

        return response()->json(['message' => 'User registered successfully'], 201);
    }

    public function sendRegisterEmail(Request $request, $user)
    {
        $token = Str::random(18);
        (new RegisterToken())
                ->updateOrCreate(['email' => $request->email], ['email' => $request->email, 'token' => $token]);

        // send registration email here... 
        // return the user email
        $url = $request->get('url') . '?token=' . $token . '&email=' . $request->email;
        $mail = new UserRegistrationEmail($url, $user);
        Mail::to($user)->send($mail);
        return;
    }

    public function verifyEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
                    'token' => 'required',
                    'email' => 'required|email'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $token_check = (new RegisterToken())->where($request->only('token', 'email'))->first();
        $user = User::where(['email' => $request->email])->first();
        if ($token_check && $user) {
            if (is_null($token_check->verified_at)) {

                $token_check->verified_at = Carbon::now();
                $user->email_verified_at = Carbon::now();
                if ($token_check->update() && $user->update()) {
                    return response()->json(['status' => 'success', 'message' => 'User vefified successfully'], 201);
                }
                return response()->json(['status' => 'error', 'message' => 'user already verified']);
            }
            return response()->json(['message' => 'user already verified']);
        }
        return response()->json(['message' => 'invalid token']);
    }

    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), ['url' => 'required', 'email' => 'required|email|exists:users']);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $token = Str::random(18);
        $data = [
            'token' => $token,
            'email' => $request->email,
            'created_at' => Carbon::now()
        ];

        if ($ptoken = PasswordResetToken::where(['email' => $request->email])) {
            $ptoken->delete();
        }

        $saved = (new PasswordResetToken())->updateOrCreate(['email' => $request->email], $data);
        if ($saved) {
            $url = $request->get('url') . '?token=' . $token . '&email=' . $request->email;

            $user = User::whereEmail($request->email)->first();
            if ($user) {
                $mail = new UserResetPasswordEmail($url, $user);
                Mail::to($user)->send($mail);

                return response()->json(['message' => 'reset password link sent'], 201);
            }
        }
        return response()->json(['status' => 'error', 'message' => 'password reset failed']);
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
                    'email' => ['required', 'string', 'email', 'max:255', 'exists:password_reset_tokens'],
                    'password' => ['required', 'string', 'min:8', 'confirmed'],
                    'token' => ['required', 'string', 'exists:password_reset_tokens']
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $reset_token = PasswordResetToken::where(['email' => $request->email, 'token' => $request->token])->first();
        $user = User::where(['email' => $request->email])->first();
        if ($reset_token && $user) {
            $user->password = Hash::make($request->password);
            if ($user->update()) {
                DB::table('password_reset_tokens')->where(['email'=>$request->email])->delete();
                return response()->json(['message' => 'password reset successfully'], 201);
            }
        }
        return response()->json(['status' => 'error', 'message' => 'password reset failed']);
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
                    'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
        $user = auth('api')->user();
        if ($user) {

            $user->password = Hash::make($request->password);
            if ($user->update()) {

                return response()->json(['message' => 'password changed successfully'], 201);
            }
        }
        return response()->json(['status' => 'error', 'message' => 'password change failed'], 401);
    }

    public function updateUserDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
                    'name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'string', 'email', 'max:255'],
                    'url' => ['required', 'string']
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
        $user = auth('api')->user();

        if (trim($user->email) !== trim($request->email)) {
            // send verification email
            // \\
            $user->email_verified_at = null;
            $this->sendRegisterEmail($request, $user);
        }
        $user->name = $request->name;
        $user->email = $request->email;

        if ($user->update()) {

            return response()->json(['message' => 'user details updated successfully'], 201);
        }
        return response()->json(['status' => 'error', 'message' => 'user details update failed'], 401);
    }
}
 /**
     * Handle Google login.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function handleGoogleLogin(Request $request)
    {
        $token = $request->input('credential');

        $client = new Google_Client(['client_id' => config('services.google.client_id')]);
        $payload = $client->verifyIdToken($token);

        if ($payload) {
            $googleId = $payload['sub'];
            $name = $payload['name'];
            $email = $payload['email'];

            // Check if the user already exists
            $user = User::where('email', $email)->first();

            if ($user) {
                // Log the user in
                Auth::login($user);
            } else {
                // Create a new user
                $user = User::create([
                    'name' => $name,
                    'email' => $email,
                    'password' => Hash::make(Str::random(16)), // Set a random password
                ]);

                // Assign role if necessary
                $user->assignRole('user');

                // Log the new user in
                Auth::login($user);
            }

            return response()->json(['success' => true, 'redirect' => url('/dashboard')]);
        } else {
            return response()->json(['success' => false, 'message' => 'Invalid Google token'], 401);
        }
    }
