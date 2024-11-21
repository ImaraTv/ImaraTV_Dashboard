<?php

namespace App\Filament\Pages;

use App\Mail\UserPasswordEmail;
use App\Mail\UserVerificationCodeEmail;
use App\Models\CreatorProposal;
use App\Models\FilmGenre;
use App\Models\FilmTopic;
use App\Models\PotentialSponsor;
use App\Models\RegisterToken;
use App\Models\User;
use Filament\Events\Auth\Registered;
use Filament\Facades\Filament;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Concerns\CanUseDatabaseTransactions;
use Filament\Pages\Concerns\InteractsWithFormActions;
use Filament\Pages\SimplePage;
use Filament\Forms\Components\Wizard;
use Filament\Support\Enums\IconSize;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Auth\SessionGuard;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class SponsorOnboarding extends SimplePage
{
    use CanUseDatabaseTransactions;
    use InteractsWithFormActions;

    protected static string $view = 'filament.pages.sponsor-onboarding';
    protected ?string $maxWidth = '5xl';

    // user fields
    public string $role = 'sponsor';
    public ?string $name;
    public ?string $email;
    public ?string $description;
    public ?int $creator_id;
    public ?int $newsletter_consent;
    public ?string $verify_code;
    // the created user instance
    public User $user;

    public function mount(): void
    {
        $creator_id = request('creator_id');
        $this->creator_id = $creator_id;
    }

    protected function getFormActions(): array
    {
        return [];
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Wizard\Step::make('My Information')
                        ->description('Enter your details')
                        ->schema($this->userInfoSchema())
                        ->afterValidation(function() {
                            // save user details and send email
                            $this->createUser();
                        }),
                    Wizard\Step::make('Verify Email')
                        ->schema($this->verifyEmailSchema())
                        ->afterValidation(function() {
                            if(!$this->doVerifyCode()) {
                                // TODO: show validation message
                                Notification::make()
                                    ->title('Verification Code is incorrect')
                                    ->body('The code you have entered is either wrong or has been used already. Try to resend the code.')
                                    ->danger()
                                    ->inline()
                                    ->send();
                                $this->halt();
                            }
                            else {
                                $this->createEOI();
                            }
                        }),
                    Wizard\Step::make('Done')
                        ->schema([
                            Section::make('Completed!')
                                ->description('Your Sponsorship Expression of Interest is successfully submitted')
                                ->icon('heroicon-o-check-badge')->iconSize(IconSize::Large)
                                ->schema([

                                ]),
                        ]) ->afterValidation(function() {
                        }),
                ])
                    //->persistStepInQueryString()
                    ->nextAction(function (Action $action) {
                    })
                    ->submitAction(new HtmlString(Blade::render(<<<BLADE
                    <x-filament::button
                        type="submit"
                        size="sm"
                        wire:click="finishOnboarding"
                    >
                        Take me to my Profile
                    </x-filament::button>
                    BLADE))),
            ]);
    }

    public function finishOnboarding()
    {
        Filament::auth()->login($this->user, true);
        // TODO: send welcome email
        $profile_url = route('filament.admin.pages.my-profile');
        $this->redirect($profile_url);
    }

    protected function userInfoSchema(): array {
        return [
            TextInput::make('name')
                ->label(__('filament-panels::pages/auth/register.form.name.label'))
                ->required()
                ->maxLength(255)
                ->columnSpan(4)
                ->autofocus(),
            TextInput::make('email')
                ->label(__('filament-panels::pages/auth/register.form.email.label'))
                ->email()
                ->required()
                ->maxLength(255)
                ->columnSpan(4)
                ->unique($this->getUserModel()),
            Textarea::make('description')
                ->required()
                ->string()
                ->minLength(5)
                ->filled()
                ->label('Description of Sponsorship')->columnSpan(4)->nullable(),
            Checkbox::make('newsletter_consent')
                ->label('I consent to receive Emails from Imara TV')
                ->required()
                ->hint('By signing up you agree to receive Emails and Newsletters from Imara TV')
                ->accepted()
        ];
    }
    protected function verifyEmailSchema(): array {
        return [
            TextInput::make('verify_code')
                ->label('Enter Verification Code')
                ->hint('Check your email for a verification code.')
                ->required()
                ->maxLength(255)
                ->autofocus(),
        ];
    }

    protected function getUserModel(): string
    {
        /** @var SessionGuard $authGuard */
        $authGuard = Filament::auth();

        /** @var EloquentUserProvider $provider */
        $provider = $authGuard->getProvider();

        return $provider->getModel();
    }

    protected function createUser()
    {
        $password = Str::password(8);
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($password),
            'role' => $this->role,
            'newsletter_consent' => $this->newsletter_consent,
        ]);

        if ($user) {
            $user->assignRole($this->role);
        }
        $this->user = $user;

        $token = Str::random(8);
        (new RegisterToken())
            ->updateOrCreate(['email' => $this->email], ['email' => $this->email, 'token' => $token]);

        $mail = new UserVerificationCodeEmail($user, $token);
        Mail::to($user)->send($mail);

        // send password to user
        $pswd_reset_page = filament()->getRequestPasswordResetUrl();
        $pswdMail = new UserPasswordEmail($pswd_reset_page, $password, $user);
        Mail::to($user)->send($pswdMail);
    }

    protected function createEOI($creator_id = null)
    {
        return PotentialSponsor::create([
            'sponsor_id' => $this->user->id,
            'creator_id' => $this->creator_id,
            'proposal_id' => null,
            'description' => $this->description,
        ]);
    }

    protected function doVerifyCode()
    {
        $code = $this->verify_code;
        $email = $this->email;

        $token_check = (new RegisterToken())->where(['token' => $code, 'email' => $email])->first();
        $user = User::where(['email' => $email])->first();
        if ($token_check && $user) {
            if (is_null($token_check->verified_at)) {
                $token_check->verified_at = Carbon::now();
                $user->email_verified_at = Carbon::now();
                if ($token_check->update() && $user->update()) {
                    event(new Registered($user));
                    return true;
                }
                else {
                    return false;
                }
            }
            return false;
        }
        return false;
    }
}
