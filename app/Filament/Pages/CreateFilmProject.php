<?php

namespace App\Filament\Pages;

use App\Mail\UserVerificationCodeEmail;
use App\Models\CreatorProposal;
use App\Models\FilmGenre;
use App\Models\FilmTopic;
use App\Models\RegisterToken;
use App\Models\User;
use Filament\Events\Auth\Registered;
use Filament\Facades\Filament;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
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

class CreateFilmProject extends SimplePage
{
    use CanUseDatabaseTransactions;
    use InteractsWithFormActions;

    protected static string $view = 'filament.pages.create-film-project';
    protected ?string $maxWidth = '5xl';

    // film fields
    public $working_title;
    public $topics;
    public $synopsis;
    public $film_budget;
    public $film_genre;
    public $film_length;
    public $production_time;
    // user fields
    public $role;
    public $name;
    public $email;
    public $newsletter_consent;
    public $verify_code;
    // the created user instance
    public $user;

    protected function getFormActions(): array
    {
        return [];
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Wizard\Step::make('Film Details')
                        ->description('Tell us about your film')
                        ->columns([
                            'sm' => 4,
                            'xl' => 4,
                            '2xl' => 4,
                        ])
                        ->schema($this->filmDetailSchema())
                        ->afterValidation(function() {
                            //
                        }),
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
                                $this->createFilmProject();
                            }
                        }),
                    Wizard\Step::make('Done')
                        ->schema([
                            Section::make('Completed!')
                                ->description('Your Film Project is successfully created')
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
                        wire:click="finishCreateFilmProject"
                    >
                        Take me to my Profile
                    </x-filament::button>
                    BLADE))),
            ]);
    }

    public function finishCreateFilmProject()
    {
        Filament::auth()->login($this->user, true);
        // TODO: send welcome email
        $profile_url = route('filament.admin.pages.my-profile');
        $this->redirect($profile_url);
    }

    protected function filmDetailSchema(): array {
        return [
            TextInput::make('working_title')
                ->required()
                ->filled()
                ->string()
                ->maxLength(255)
                ->label('Working Title')->columnSpan(['sm' => 4, 'md' => 2, 'xl' => 2, 'default' => 4]),
            Select::make('topics')
                //->multiple()
                ->options(FilmTopic::all()->pluck('topic_name', 'id'))
                ->label('Topics (Select All Related Topics)')->columnSpan(['sm' => 4, 'md' => 2, 'xl' => 2, 'default' => 4])->nullable(),
            Textarea::make('synopsis')
                ->required()
                ->string()
                ->minLength(5)
                ->filled()
                ->label('Synopsis')->columnSpan(4)->nullable(),
            TextInput::make('film_budget')
                ->required()
                ->type('number')
                ->minValue(1000)
                ->numeric()
                ->filled()
                ->label('Film Budget (KES)')->columnSpan(['sm' => 4, 'md' => 2, 'xl' => 2, 'default' => 4])->nullable(),
            Select::make('film_genre')
                ->label('Film Genre  (Leave blank if optional)')
                ->options(FilmGenre::all()->pluck('genre_name', 'id'))->columnSpan(['sm' => 4, 'md' => 2, 'xl' => 2, 'default' => 4])->nullable(),
            TextInput::make('film_length')
                ->required()
                ->type('number')
                ->numeric()
                ->label('Film Length (Minutes)')->columnSpan(['sm' => 4, 'md' => 2, 'xl' => 2, 'default' => 4])->nullable(),
            TextInput::make('production_time')
                ->required()
                ->type('number')
                ->numeric()
                ->label('Production Time (Days)')->columnSpan(['sm' => 4, 'md' => 2, 'xl' => 2, 'default' => 4])->nullable(),


        ];
    }

    protected function userInfoSchema(): array {
        return [
            Select::make('role')
                ->label('I am a')
                ->required()
                ->options(['creator' => 'Creator', 'sponsor' => 'Sponsor']),
            TextInput::make('name')
                ->label(__('filament-panels::pages/auth/register.form.name.label'))
                ->required()
                ->maxLength(255)
                ->autofocus(),
            TextInput::make('email')
                ->label(__('filament-panels::pages/auth/register.form.email.label'))
                ->email()
                ->required()
                ->maxLength(255)
                ->unique($this->getUserModel()),
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
    }

    protected function createFilmProject()
    {
        return CreatorProposal::create([
            'working_title' => $this->working_title,
            'synopsis' => $this->synopsis,
            'film_budget' => $this->film_budget,
            'film_length' => $this->film_length,
            'production_time' => $this->production_time,
            'film_genre' => $this->film_genre,
            'topics' => collect($this->topics)->implode(','),
            'user_id' => $this->user->id,
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
