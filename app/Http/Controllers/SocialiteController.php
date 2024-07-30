<?php

namespace App\Http\Controllers;

use App\Mail\UserRegistrationEmail;
use App\Models\RegisterToken;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Filament\Facades\Filament;
use Monolog\Logger;

class SocialiteController extends Controller
{
    public function redirect(string $provider)
    {
        $this->validateProvider($provider);

        return Socialite::driver($provider)->stateless()->redirect();;
    }

    public function callback(string $provider)
    {
        $this->validateProvider($provider);

        $response = Socialite::driver($provider)->stateless()->user();

        $user = User::firstWhere(['email' => $response->getEmail()]);

        if ($user) {
            $user->update([$provider . '_id' => $response->getId()]);
            Filament::auth()->login($user, true);
            return redirect()->to(route('filament.admin.pages.my-profile'));
        } else {
            $user = User::create([
                $provider . '_id' => $response->getId(),
                'name'            => $response->getName(),
                'email'           => $response->getEmail(),
                'password'        => Hash::make('testUser'),
                'email_verified_at' => date('Y-m-d H:i:s'),
                'role' => 'creator',
            ]);

            if ($user) {
                //$user->assignRole('user');
                /*$token = Str::random(18);
                (new RegisterToken())
                    ->updateOrCreate(['email' => $user->email], ['email' => $user->email, 'token' => $token]);

                // send registration email here...
                // return the user email
                $url = env('APP_URL') . '/email-verified' . '?token=' . $token . '&email=' . $user->email;
                $mail = new UserRegistrationEmail($url, $user);
                Mail::to($user)->send($mail);
                */
                //Auth::login($user, true);
                Filament::auth()->login($user, true);
                return redirect()->to(route('filament.admin.pages.my-profile'));
            }
        }

        return redirect()->intended(route('filament.admin.pages.dashboard'));
    }

    protected function validateProvider(string $provider): array
    {
        return $this->getValidationFactory()->make(
            ['provider' => $provider],
            ['provider' => 'in:google']
        )->validate();
    }

    /**
     * Get a validation factory instance.
     *
     * @return \Illuminate\Contracts\Validation\Factory
     */
    protected function getValidationFactory()
    {
        return app('Illuminate\Contracts\Validation\Factory');
    }
}
