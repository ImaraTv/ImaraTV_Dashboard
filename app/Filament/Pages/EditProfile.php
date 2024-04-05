<?php

namespace App\Filament\Pages;

use App\Models\{
    AdminProfile,
    CreatorProfile,
    FilmTopic,
    Location,
    SponsorProfile
};
use Filament\{
    Actions\Action,
    Forms\Components\Card,
    Forms\Components\DatePicker,
    Forms\Components\Select,
    Forms\Components\SpatieMediaLibraryFileUpload,
    Forms\Components\TagsInput,
    Forms\Components\Textarea,
    Forms\Components\TextInput,
    Forms\Concerns\InteractsWithForms,
    Forms\Contracts\HasForms,
    Forms\Form,
    Notifications\Notification,
    Pages\Page
};
use function auth;
use function collect;

class EditProfile extends Page implements HasForms
{

    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.edit-profile';

    protected static ?string $model = AdminProfile::class;

    public ?array $data = [];

    public ?array $fdata = [];

    public ?SponsorProfile $sponsorProfile = null;

    public ?CreatorProfile $creatorProfile = null;

    public ?AdminProfile $adminProfile = null;


    public function mount(): void
    {
        if (auth()->user()->hasRole('sponsor')) {
            self::$model = SponsorProfile::class;
            $sponsor_form = collect(SponsorProfile::where('user_id', auth()->id())->first())->toArray();
            self::$model = SponsorProfile::class;
            if ($sponsor_form) {
                $this->fdata = $sponsor_form;
            } else {
                $this->fdata = (new SponsorProfile())->toArray();
            }

            $this->form->fill(
                    $this->fdata
            );
        }
        if (auth()->user()->hasRole('creator')) {
            self::$model = CreatorProfile::class;
            $creator_form = collect(CreatorProfile::where('user_id', auth()->id())->first())->toArray();
            if ($creator_form) {
                $this->fdata = $creator_form;
            } else {
                $this->fdata = (new CreatorProfile())->toArray();
            }
            $this->fdata = array_merge(collect(auth()->user())->only('email', 'name')->toArray(), $this->fdata);
            $this->form->fill(
                    $this->fdata
            );
        }
        if (auth()->user()->hasRole('admin|super_admin')) {
            self::$model = AdminProfile::class;
            $admin_form = collect(AdminProfile::where('user_id', auth()->id())->first())->toArray();
            if ($admin_form) {
                $this->fdata = $admin_form;
            } else {
                $this->fdata = (new AdminProfile())->toArray();
            }
            $this->fdata = array_merge(collect(auth()->user())->only('email', 'name')->toArray(), $this->fdata);
            $this->form->fill(
                    $this->fdata
            );
        }
    }

    protected function adminForm()
    {
        return Card::make()->schema(
                        [
                                    SpatieMediaLibraryFileUpload::make('profile_picture')
                                    ->name('profile_picture')
                                    ->label('Profile Picture')
                                    ->collection('profile_pictures')
                                    ->columnSpanFull(),
                                    TextInput::make('name')
                                    ->columnSpan(2),
                                    TextInput::make('email')
                                    ->email()
                                    ->columnSpan(2),
                                    TextInput::make('mobile_phone')
                                    ->columnSpan(2),
                        ]
                )->columns(6);
    }

    protected function sponsorForm()
    {
        return Card::make()->schema(
                        [
                                    SpatieMediaLibraryFileUpload::make('logo')
                                    ->image()
                                    ->name('Organization Logo')
                                    ->collection('logo')
                                    ->columnSpan(2)->nullable(),
//                            --
                            Textarea::make('about_us')
                                    ->rows(5)
                                    ->required()
                                    ->columnSpan('4')
                                    ->label('About Us')->nullable(),
//                            --
                            TextInput::make('organization_name')
                                    ->columnSpan(3)
                                    ->label('Organization Name')->nullable(),
//                            --
                            TextInput::make('organization_website')
                                    ->url()
                                    ->suffixIcon('heroicon-m-globe-alt')
                                    ->columnSpan(3)
                                    ->label('Organization Website')->nullable(),
//                            --
                            TagsInput::make('topics_of_interest')
                                    ->placeholder('Topics of Interst')
                                    ->suggestions(FilmTopic::all()->pluck('topic_name'))
                                    ->columnSpanFull()
                                    ->label('Topics of Interest')->nullable(),
//                            --
                            TagsInput::make('locations_of_interest')
                                    ->suggestions(Location::all()->pluck('location_name'))
                                    ->separator(',')
                                    ->placeholder('locations of interest')
                                    ->separator(',')
                                    ->columnSpanFull()
                                    ->label('Locations of Interest')->nullable(),
//                            --
                            TextInput::make('contact_person_name')
                                    ->columnSpan(3)
                                    ->label('Contact Person Name')->nullable(),
//                            --
                            TextInput::make('contact_person_email')
                                    ->columnSpan(3)
                                    ->label('Contact Person Email')->email()->nullable(),
                                    TextInput::make('contact_person_phone')
                                    ->columnSpan(3)
                                    ->label('Contact Person Phone')->nullable(),
//                            --
                            TextInput::make('contact_person_alt_phone')
                                    ->columnSpan(3)
                                    ->label('Contact Person Alt Phone')->nullable(),
                        ]
                )->columns(6);
    }

    protected function creatorForm()
    {
        return Card::make()->schema(
                        [
                                    SpatieMediaLibraryFileUpload::make('attachments')
                                    ->name('profile_picture')
                                    ->label('Profile Picture')
                                    ->collection('creator_profile')
                                    ->columnSpan(2),
                                    SpatieMediaLibraryFileUpload::make('profile_banner')
                                    ->collection('creator_profile')
                                    ->columnSpan(4),
                                    TextInput::make('name')
                                    ->columnSpan(3),
                                    TextInput::make('stage_name')
                                    ->columnSpan(3),
                                    TextInput::make('email')
                                    ->email()
                                    ->columnSpan(3),
                                    TextInput::make('mobile_phone')
                                    ->columnSpan(3),
                                    Textarea::make('description')
                                    ->label('About Me')
                                    ->columnSpan(6),
                                    TagsInput::make('skills_and_talents')
                                    ->separator(',')
                                    ->name('skills_and_talents')->columnSpan(6),
                                    TextInput::make('identification_number')
                                    ->columnSpan(3),
                                    DatePicker::make('date_of_birth')
                                    ->columnSpan(3),
//                                --
                            Select::make('payment_via')
                                    ->options([
                                        'mpesa' => 'Safaricom Mpesa',
                                        'kcb' => 'KCB',
                                        'stan_chart' => 'Stan Chart',
                                    ])->columnSpan(3)
                                    ->label('Payment Via (Bank Name or Mobile Money)'),
//                                --
                            TextInput::make('payment_account_number')
                                    ->label('Payment Account Number')
                                    ->columnSpan(3),
//                                --
                            TextInput::make('kra_pin')
                                    ->name('kra_pin')
                                    ->label('KRA PIN')
                                    ->columnSpan(3),
//                                --
                            Select::make('location')
                                    ->options([
                                        'kajiado' => 'Kajiado',
                                        'nairobi' => 'Nairobi',
                                        'nakuru' => 'Nakuru',
                                    ])->columnSpan(3)
                                    ->label('Location'),
                        ]
                )->columns(6);
    }

    public function form(Form $form): Form
    {
        if (auth()->user()->hasRole('creator')) {
            return $form
                            ->schema([
                                $this->creatorForm()
                            ])
                            ->statePath('data')
            ;
        }
        if (auth()->user()->hasRole('sponsor')) {
            return $form
                            ->schema([
                                $this->sponsorForm()
                            ])->statePath('data');
        }
//        dd(!auth()->user()->hasRole(['admin','super']));
        if (auth()->user()->hasRole('admin|super_admin')) {
            return $form
                            ->schema([
                                $this->adminForm()
                            ])->statePath('data');
        }
    }

    protected function getFormActions(): array
    {
        return [
                    Action::make('Update')
                    ->color('primary')
                    ->submit('Update'),
        ];
    }

    public function update()
    {
        auth()->user()->update(
                $this->form->getState()
        );

        if (auth()->user()->hasRole('sponsor')) {

            SponsorProfile::updateOrCreate(['user_id' => auth()->user()->id], $this->data);
        }
        if (auth()->user()->hasRole('creator')) {


            creatorProfile::updateOrCreate(['user_id' => auth()->user()->id], $this->form->getState());
        }
        if (auth()->user()->hasRole('admin|super_admin')) {



            $data = collect($this->data)->only('mobile_phone')->toArray();

            $profile = AdminProfile::updateOrCreate(['user_id' => auth()->user()->id], $data);
            if ($profile) {
                $profile->addMedia(collect($this->data['profile_picture'])->first()->pathname);
            }
        }

        Notification::make()
                ->title('Profile updated!')
                ->success()
                ->send();
    }

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }
}
