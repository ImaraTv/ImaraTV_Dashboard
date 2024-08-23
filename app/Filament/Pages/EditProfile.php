<?php

namespace App\Filament\Pages;

use App\Models\{AdminProfile, CreatorProfile, FilmTopic, Location, SponsorProfile, User};
use Filament\{
    Forms\Components\Card,
    Forms\Components\DatePicker,
    Forms\Components\FileUpload,
    Forms\Components\Select,
    Forms\Components\SpatieMediaLibraryFileUpload,
    Forms\Components\TagsInput,
    Forms\Components\Textarea,
    Forms\Components\TextInput,
    Forms\Concerns\InteractsWithForms,
    Forms\Contracts\HasForms,
    Forms\Form,
    Infolists\Components\Actions,
    Infolists\Components\Actions\Action,
    Infolists\Components\ImageEntry,
    Infolists\Components\Section,
    Infolists\Components\TextEntry,
    Infolists\Infolist,
    Notifications\Notification,
    Pages\Page,
    Support\Enums\MaxWidth
};
use function __;
use function auth;
use function collect;
use function storage_path;

class EditProfile extends Page implements HasForms
{

    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $title = 'My Profile';

    public static ?string $slug = 'my-profile';

    protected static string $view = 'filament.pages.edit-profile';

    protected static ?string $model = AdminProfile::class;

    public ?array $data = [];

    public ?array $fdata = [];

    public ?SponsorProfile $sponsorProfile = null;

    public ?CreatorProfile $creatorProfile = null;

    public ?AdminProfile $adminProfile = null;


    public static function getLabel(): string
    {
        return 'My Profile';
    }

    public function getTitle(): \Illuminate\Contracts\Support\Htmlable|string
    {
        $label = 'My Profile';
        if (auth()->user()->hasRole('sponsor')) {
            $label = 'My Sponsor Profile';
        }
        if (auth()->user()->hasRole('creator')) {
            $label = 'My Creator Profile';
        }
        if (auth()->user()->hasRole('admin|super_admin')) {
            $label = 'My Admin Profile';
        }
        return $label;
    }

    public function getViewData(): array
    {
        $user = auth()->user();
        $incomplete_fields = $this->incompleteFields();
        $data = $this->fdata;
        return compact('user', 'incomplete_fields', 'data');
    }

    public function incompleteFields(): array
    {
        $data = $this->fdata;
        $incomplete_fields = [];
        if (auth()->user()->hasRole('creator')) {
            $mandatory_fields = ['name', 'email', 'mobile_phone', 'identification_number', 'profile_picture'];
            foreach ($mandatory_fields as $field) {
                if (array_key_exists($field, $data) && empty($data[$field])) {
                    $incomplete_fields[] = $field;
                }
            }
        }
        if (auth()->user()->hasRole('sponsor')) {
            $mandatory_fields = ['about_us', 'organization_name', 'contact_person_name', 'contact_person_email'];
            foreach ($mandatory_fields as $field) {
                if (array_key_exists($field, $data) && empty($data[$field])) {
                    $incomplete_fields[] = $field;
                }
            }
        }
        return $incomplete_fields;
    }

    public function isProfileIncomplete(): bool
    {
        return empty($this->incompleteFields());
    }

    public function mount(): void
    {
        if (auth()->user()->hasRole('sponsor')) {

            $sponsor_form = SponsorProfile::with(['user'])->where('user_id', auth()->id())->first();

            $d = [
                'logo' => ''
            ];
            if ($sponsor_form) {
                $logo = collect($sponsor_form->getMedia('logo'))->last();
                if ($logo) {
                    $d['logo'] = $logo->getUrl();
                }
                $this->fdata = array_merge(collect($sponsor_form)->toArray(), $d);
            } else {
                $this->fdata = (new SponsorProfile())->toArray();
            }


            $this->form->fill(
                    $this->fdata
            );
        }
        if (auth()->user()->hasRole('creator')) {
            self::$model = CreatorProfile::class;
            $creator_form = CreatorProfile::with(['user', 'loc'])->where('user_id', auth()->id())->first();
            if ($creator_form) {

                $d = [
                    'profile_picture' => '',
                    'profile_banner' => ''
                ];

                $image = collect($creator_form->getMedia('profile_pictures'))->last();
                if ($image) {
                    $d['profile_picture'] = $image->getUrl();
                }
                $banner = collect($creator_form->getMedia('profile_banners'))->last();
                if ($banner) {
                    $d['profile_banner'] = $banner->getUrl();
                }

                $this->fdata = array_merge(collect($creator_form)->toArray(), $d);
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
            $admin_form = AdminProfile::where('user_id', auth()->id())->exists();
            if ($admin_form) {


                $model = AdminProfile::with('user')->where('user_id', auth()->id())->first();
                $image = collect($model->getMedia('profile_pictures'))->last();

                $d = ([
                    'profile_picture' => $image->getUrl(),
                    'email' => $model->user->email,
                    'mobile_phone' => $model->mobile_phone,
                    'name' => $model->user->name
                ]);

                $this->fdata = $d;
            } else {
                $this->fdata = (new AdminProfile())->toArray();
            }
            $this->fdata = array_merge(collect(auth()->user())->only('email', 'name')->toArray(), $this->fdata);
            $this->form->fill(
                    $this->fdata
            );
        }

        if(!auth()->user()->hasRole(['sponsor', 'creator', 'admin', 'super_admin'])) {
            self::$model = User::class;
            $this->fdata = ['role' => ''];
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
                ->image()
                ->name('profile_picture')
                ->label('Profile Picture')
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
                            TextInput::make('default_call_to_action')
                                    ->columnSpan(3)
                                    ->label('Call to Action')->required(),
//                            --
                            TextInput::make('default_call_to_action_link')
                                    ->url()
                                    ->suffixIcon('heroicon-m-globe-alt')
                                    ->columnSpan(3)
                                    ->label('Call to Action Link')->required(),
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

    protected function chooseRoleForm()
    {
        $role = 'creator';
        return Card::make()->schema(
            [
                Select::make('role')
                    ->label('Continue Profile Registration as?')
                    ->required()
                    ->default($role)
                    ->options(['creator' => 'Creator', 'sponsor' => 'Sponsor']),

            ]
        )->columns(6);
    }

    protected function sponsorProfileInfo(Infolist $list): Infolist
    {
        return $list->schema([
                            Section::make()
                            ->schema([
                                ImageEntry::make('logo')->columnSpan(2),
                                TextEntry::make('about_us')->columnSpan(2),
                                TextEntry::make('organization_name')->columnSpan(2),
                                TextEntry::make('organization_website')->columnSpan(2),
                                TextEntry::make('defeault_call_to_action')->columnSpan(2),
                                TextEntry::make('default_call_to_action_link')->columnSpan(2),
                                TextEntry::make('topics_of_interest')->columnSpan(2),
                                TextEntry::make('locations_of_interest')->columnSpan(2),
                                TextEntry::make('contact_person_name')->columnSpan(2),
                                TextEntry::make('contact_person_email')->columnSpan(2),
                                TextEntry::make('contact_person_phone')->columnSpan(2),
                                TextEntry::make('contact_person_alt_phone')->columnSpan(2),
                                Actions::make([
                                    Action::make('Update Profile')
                                    ->fillForm($this->fdata)
                                    ->form(
                                            $this->sponsorFrm()
                                    )
                                    ->action(function (array $data): void {

                                        $this->saveSponsorProfile($data);
                                        Notification::make()
                                        ->title('Profile updated!')
                                        ->success()
                                        ->send();
                                    })
                                    ->closeModalByClickingAway(false)
                                    ->modalWidth(MaxWidth::FourExtraLarge)
                                ])->columns(4)
                            ])->columns(4)
                ])->state($this->fdata);
        ;
    }

    protected function sponsorFrm(): array
    {
        return
                [
                            FileUpload::make('logo')
                            ->image()
                            ->name('Organization Logo')
                            ->columnSpan(4)->nullable(),
//                            --
                    Textarea::make('about_us')
                            ->rows(5)
                            ->required()
                            ->columnSpan(4)
                            ->label('About Us')->nullable(),
//                            --
                    TextInput::make('organization_name')
                            ->columnSpan(2)
                            ->label('Organization Name')->nullable(),
//                            --
                    TextInput::make('organization_website')
                            ->url()
                            ->suffixIcon('heroicon-m-globe-alt')
                            ->columnSpan(2)
                            ->label('Organization Website')->nullable(),
//                            --
                    TextInput::make('default_call_to_action')
                            ->columnSpan(2)
                            ->label('Default Call to Action')->required(),
//                            --
                    TextInput::make('default_call_to_action_link')
                            ->url()
                            ->suffixIcon('heroicon-m-globe-alt')
                            ->columnSpan(2)
                            ->label('Call to Action Link')->required(),
//                            --
                    TagsInput::make('topics_of_interest')
                            ->placeholder('Topics of Interst')
                            ->suggestions(FilmTopic::all()->pluck('topic_name'))
                            ->columnSpan(2)
                            ->label('Topics of Interest')->nullable(),
//                            --
                    TagsInput::make('locations_of_interest')
                            ->suggestions(Location::all()->pluck('location_name'))
                            ->separator(',')
                            ->placeholder('locations of interest')
                            ->separator(',')
                            ->columnSpan(2)
                            ->label('Locations of Interest')->nullable(),
//                            --
                    TextInput::make('contact_person_name')
                            ->columnSpan(2)
                            ->label('Contact Person Name')->nullable(),
//                            --
                    TextInput::make('contact_person_email')
                            ->columnSpan(2)
                            ->label('Contact Person Email')->email()->nullable(),
                            TextInput::make('contact_person_phone')
                            ->columnSpan(2)
                            ->label('Contact Person Phone')->nullable(),
//                            --
                    TextInput::make('contact_person_alt_phone')
                            ->columnSpan(2)
                            ->label('Contact Person Alt Phone')->nullable(),
        ];
    }

    protected function creatorFrm(): array
    {
        return [
                    FileUpload::make('profile_picture')
                    ->name('profile_picture')
                    ->columnSpan(2),
                    FileUpload::make('profile_banner')
                    ->name('profile_banner')
                    ->columnSpan(2),
                    TextInput::make('name')
                    ->columnSpan(2),
                    TextInput::make('stage_name')
                    ->columnSpan(2),
                    TextInput::make('email')
                    ->email()
                    ->columnSpan(2),
                    TextInput::make('mobile_phone')
                    ->columnSpan(2),
                    Textarea::make('description')
                    ->label('About Me')
                    ->columnSpan(4),
                    TagsInput::make('skills_and_talents')
                    ->separator(',')
                    ->name('skills_and_talents')->columnSpan(4),
                    TextInput::make('identification_number')
                    ->columnSpan(2),
                    DatePicker::make('date_of_birth')
                    ->columnSpan(2),
//                                --
            Select::make('payment_via')
                    ->options([
                        'mpesa' => 'Safaricom Mpesa',
                        'kcb' => 'KCB',
                        'stan_chart' => 'Stan Chart',
                    ])->columnSpan(2)
                    ->label('Payment Via (Bank Name or Mobile Money)'),
//                                --
            TextInput::make('payment_account_number')
                    ->label('Payment Account Number')
                    ->columnSpan(2),
//                                --
            TextInput::make('kra_pin')
                    ->name('kra_pin')
                    ->label('KRA PIN')
                    ->columnSpan(2),
//                                --
            Select::make('location')
                    ->options(Location::all()->pluck('location_name', 'id'))->columnSpan(2)
                    ->label('Location'),
        ];
    }

    protected function creatorProfileInfo(Infolist $list): Infolist
    {
        return $list->schema([
                            Section::make()
                            ->schema([
                                ImageEntry::make('profile_picture')->columnSpan(2),
                                ImageEntry::make('profile_banner')->columnSpan(2),
                                TextEntry::make('name')->columnSpan(2),
                                TextEntry::make('email')->columnSpan(2),
                                TextEntry::make('mobile_phone')->columnSpan(2),
                                TextEntry::make('stage_name')->columnSpan(2),
                                TextEntry::make('description')->columnSpan(4),
                                TextEntry::make('skills_and_talents')->columnSpan(2),
                                TextEntry::make('identification_number')->columnSpan(2),
                                TextEntry::make('date_of_birth')->columnSpan(2),
                                TextEntry::make('payment_via')->columnSpan(2),
                                TextEntry::make('payment_account_number')->columnSpan(2),
                                TextEntry::make('kra_pin')->columnSpan(2),
                                TextEntry::make('location.location_name')->columnSpan(2),
                                Actions::make([
                                    Action::make('Update Profile')
                                    ->fillForm($this->fdata)
                                    ->form(
                                            $this->creatorFrm()
                                    )
                                    ->action(function (array $data): void {

                                        $this->saveCreatorProfile($data);
                                        Notification::make()
                                        ->title('Profile updated!')
                                        ->success()
                                        ->send();
                                    })
                                    ->closeModalByClickingAway(false)
                                    ->modalWidth(MaxWidth::FourExtraLarge)
                                ])
                            ])->columns(4)
                            ->state($this->fdata)
                        ])
                        ->state($this->fdata);
    }

    protected function adminProfileInfo(Infolist $list): Infolist
    {
        return $list->schema([
                            Section::make()
                            ->columns(4)
                            ->schema([
                                TextEntry::make('name')->columnSpan(2),
                                TextEntry::make('email')->columnSpan(2),
                                TextEntry::make('phone_number')->columnSpan(2),
                                ImageEntry::make('profile_picture')->columnSpan(2),
                                Actions::make([
                                    Action::make('Update Profile')
                                    ->mountUsing(function (Form $form) {
                                        $form->fill($this->fdata);
                                    })
                                    ->icon('heroicon-m-star')
                                    ->form(
                                            [
                                                FileUpload::make('profile_picture')
                                                ->image()
                                                ->nullable()
                                                ->name('profile_picture')
                                                ->label('Profile Picture')
                                                ->columnSpanFull(),
                                                TextInput::make('name')
                                                ->columnSpan(2),
                                                TextInput::make('email')
                                                ->email()
                                                ->columnSpan(2),
                                                TextInput::make('mobile_phone')
                                                ->columnSpan(2),
                                            ]
                                    )->action(function (array $data): void {
                                        $this->saveAdminProfile($data);
                                        Notification::make()
                                        ->title('Profile updated!')
                                        ->success()
                                        ->send();
                                    })
                                    ->closeModalByClickingAway(false),
                                ])
                            ])->state($this->fdata)
                        ])
                        ->state($this->fdata);
    }

    protected function chooseRoleInfo(Infolist $list): Infolist
    {
        $role = 'creator';
        return $list->schema([
            Section::make()
                ->columns(2)
                ->schema([
                    //TextEntry::make('role')->columnSpan(2),
                    Actions::make([
                        Action::make('Click to Choose Role')
                            ->mountUsing(function (Form $form): void {
                                $form->fill($this->fdata);
                            })
                            ->icon('heroicon-m-star')
                            ->form(
                                [
                                    Select::make('role')
                                        ->columnSpan(2)
                                        ->label('Continue Profile Registration as?')
                                        ->required()
                                        ->default($role)
                                        ->options(['creator' => 'Creator', 'sponsor' => 'Sponsor']),
                                ]
                            )->action(function (array $data): void {
                                $this->saveUpdatedUserRole($data);
                                Notification::make()
                                    ->title('Role updated!')
                                    ->success()
                                    ->send();
                            })
                            ->closeModalByClickingAway(false),
                    ])
                ])->columns(4)->state($this->fdata)
        ])
            ->state($this->fdata);
    }

    public function profileInfo(Infolist $list): Infolist
    {

        if (auth()->user()->hasRole('admin|super_admin')) {
            return $this->adminProfileInfo($list);
        }
        else if (auth()->user()->hasRole('creator')) {
            return $this->creatorProfileInfo($list);
        }
        else if (auth()->user()->hasRole('sponsor')) {
            return $this->sponsorProfileInfo($list);
        }
        else {
            return $this->chooseRoleInfo($list);
        }
    }

    public function form(Form $form): Form
    {
        if (auth()->user()->hasRole('creator')) {
            return $form->schema([$this->creatorForm()])->statePath('data');
        }
        else if (auth()->user()->hasRole('sponsor')) {
            return $form->schema([$this->sponsorForm()])->statePath('data');
        }
        else if (auth()->user()->hasRole('admin|super_admin')) {
            return $form->schema([$this->adminForm()])->statePath('data');
        }
        else {
            return $form->schema([$this->chooseRoleForm()])->statePath('data');
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

    protected function saveSponsorProfile($data): void
    {
        $profile_data = collect($data)->except('logo')->toArray();
        $model = SponsorProfile::updateOrCreate(['user_id' => auth()->user()->id], $profile_data);
        if (!is_null($data['logo'])) {
            $picture_path = storage_path() . '/app/public/' . $data['logo'];
            if (file_exists($picture_path)) {
                $model->addMedia($picture_path)
                        ->usingName(auth()->id() . ' Logo')
                        ->toMediaCollection('logo');
            }
        }
    }

    protected function saveCreatorProfile($data): void
    {
        $profile_data = collect($data)->except('profile_picture', 'profile_banner')->toArray();
        $model = creatorProfile::updateOrCreate(['user_id' => auth()->user()->id], $profile_data);
        if (!is_null($data['profile_picture'])) {
            $picture_path = storage_path() . '/app/public/' . $data['profile_picture'];
            if (file_exists($picture_path)) {
                $model->addMedia($picture_path)
                        ->usingName(auth()->id() . ' Profile Picture')
                        ->toMediaCollection('profile_pictures');
            }
        }
        if (!is_null($data['profile_banner'])) {
            $banner_path = storage_path() . '/app/public/' . $data['profile_banner'];

            if (file_exists($banner_path)) {
                $model->addMedia($banner_path)
                        ->usingName(auth()->id() . ' Profile Banner')
                        ->toMediaCollection('profile_banners');
            }
        }
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

                $file = collect($this->data['profile_picture'])->first();

                // delete media if exists

                $path_name = $file->getPathName();
                $profile->addMedia($path_name)
                        ->usingName(auth()->id() . ' Profile Picture')
                        ->toMediaCollection('profile_pictures');
            }
        }

        Notification::make()
                ->title('Profile updated!')
                ->success()
                ->send();
    }

    protected function saveAdminProfile(array $data): void
    {
        $profile_data = collect($data)->only('mobile_phone')->toArray();

        $model = AdminProfile::updateOrCreate(['user_id' => auth()->user()->id], $profile_data);
        if ($model) {

            if (!is_null($data['profile_picture'])) {
                $picture_path = storage_path() . '/app/public/' . $data['profile_picture'];
                if (file_exists($picture_path)) {
                    $model->addMedia($picture_path)
                            ->usingName(auth()->id() . ' Profile Picture')
                            ->toMediaCollection('profile_pictures');
                }
            }
        }
    }

    protected function saveUpdatedUserRole(array $data): void
    {
        $data = collect($data)->only('role')->toArray();
        $user = User::updateOrCreate(['id' => auth()->user()->id], $data);
        $user->assignRole($data['role']);
        // then refresh the page
    }

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }
}
