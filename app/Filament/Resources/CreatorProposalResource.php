<?php

namespace App\Filament\Resources;

use App\{Exports\FilmProjectsExport,
    Filament\Pages\FileUploader,
    Filament\Resources\CreatorProposalResource\Pages,
    Jobs\UploadVideoToVimeo,
    Models\CreatorProfile,
    Models\CreatorProposal,
    Models\FilmGenre,
    Models\FilmTopic,
    Models\PotentialSponsor,
    Models\ProposalStatus,
    Models\SponsorProfile,
    Models\User};
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\{Forms\Components\Card,
    Forms\Components\DatePicker,
    Forms\Components\Select,
    Forms\Components\SpatieMediaLibraryFileUpload,
    Forms\Components\TagsInput,
    Forms\Components\Textarea,
    Forms\Components\TextInput,
    Forms\Form,
    Forms\Get,
    Infolists\Components\Grid,
    Infolists\Components\RepeatableEntry,
    Infolists\Components\TextEntry,
    Navigation\NavigationItem,
    Notifications\Notification,
    Resources\Resource,
    Support\Enums\ActionSize,
    Tables,
    Tables\Actions\Action,
    Tables\Actions\ActionGroup,
    Tables\Columns\TextColumn,
    Tables\Enums\FiltersLayout,
    Tables\Filters\Filter,
    Tables\Filters\SelectFilter,
    Tables\Table};
use Illuminate\Database\Eloquent\{Builder, Model};
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use function auth;
use function collect;
use function config;

class CreatorProposalResource extends Resource implements HasShieldPermissions
{

    protected static ?string $model = CreatorProposal::class;

    protected static ?string $modelLabel = 'Film Project';

    public static ?string $slug = 'film-projects';

    protected static ?string $navigationIcon = 'heroicon-s-film';

    protected static ?string $navigationLabel = 'Film Projects';

    protected static ?int $navigationSort = 2;

    public ?array $data = [];


    public static function getPermissionPrefixes(): array
    {
        return [
            'view',
            'view_any',
            'create',
            'update',
            'delete',
            'delete_any',
            'change_status',
            'assign_sponsor',
            'assign_creator'
        ];
    }

    public static function getNavigationLabel(): string
    {
        if (auth()->user()->hasRole('creator')) {
            return 'Film Projects';
        }
        if (auth()->user()->hasRole('sponsor')) {
            return 'Creator Proposals';
        }

        return 'Film Projects';
    }

    #[\Override]
    public static function canAccess(): bool
    {
        return boolval(auth()->user()->approved);
    }

    public static function canCreate(): bool
    {
        return self::profileComplete();
    }

    public static function profileComplete()
    {
        if (auth()->user()->hasRole('creator')) {
            $profile = CreatorProfile::where(['user_id' => auth()->id()])->first();
            if ($profile) {
                $nc = collect($profile)->except('deleted_at', 'created_at', 'updated_at')
                        ->filter(fn($i) => is_null($i) || $i = "" || strlen($i) == 0)
                        ->count();
                if ($nc == 0) {
                    return true;
                }
            }
            return false;
        }
        return true;
    }

    public static function form(Form $form): Form
    {

        $can_change_status = auth()->user()->can('change_status_creator::proposal');
        $can_assign_sponsor = auth()->user()->can('assign_sponsor_creator::proposal');
        $can_assign_creator = auth()->user()->can('assign_creator_creator::proposal');
        $can_create_proposal = self::profileComplete();
        return $form
                        ->disabled(!$can_create_proposal)
                        ->schema([
                            Card::make()->schema([
                                TextInput::make('working_title')
                                    ->required()
                                    ->filled()
                                    ->string()
                                    ->maxLength(255)
                                    ->label('Working Title')
                                    ->columnSpan(4),
                                TagsInput::make('topics')
                                    ->separator(',')
                                    ->suggestions(FilmTopic::all()->pluck('topic_name'))
                                    ->label('Topics (Select All Related Topics)')->columnSpan(4)->nullable(),
                                Textarea::make('synopsis')
                                    ->label('Synopsis')
                                    ->columnSpanFull()
                                    ->nullable(),
                                TextInput::make('film_budget')
                                    ->required()
                                    ->type('number')
                                    ->minValue(1000)
                                    ->numeric()
                                    ->filled()
                                    ->label('Film Budget (KES)')
                                    ->columnSpan(4)->nullable(),
                                TextInput::make('film_length')
                                    ->type('number')
                                    ->numeric()
                                    ->label('Film Length (Minutes)')->columnSpan(4)->nullable(),
                                TextInput::make('production_time')
                                    ->type('number')
                                    ->numeric()
                                    ->label('Production Time (Days)')->columnSpan(4)->nullable(),
                                Select::make('film_genre')
                                    ->label('Film Genre  (Leave blank if optional)')
                                    ->options(FilmGenre::all()->pluck('genre_name', 'id'))->columnSpan(4)->nullable(),
                                Select::make('film_rating')
                                    ->columnSpan(4)
                                    ->label('Film Rating')
                                ->options([
                                    'pre-teen' => 'Pre-Teens',
                                    'teen' => 'Teens',
                                    'adult' => 'Adults'
                                ]),
                                Select::make('film_type')
                                    ->live()
                                    ->label('Film Type (Free or Premium)')->options([
                                        'free' => 'Free',
                                        'premium' => 'Premium',
                                    ])->columnSpan(4)->nullable(),
                                TextInput::make('premium_file_price')
                                    ->disabled(fn(Get $get) => $get('film_type') == 'free')
                                    ->label('Premium Film Price per view (KES)')
                                    ->type('number')->columnSpan(4)->nullable(),
                                SpatieMediaLibraryFileUpload::make('attachments')
                                ->label('Script')
                                ->maxSize(100000)
                                ->collection('scripts')
                                ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                                ->columnSpan(4)->nullable(),
//                                --
                                SpatieMediaLibraryFileUpload::make('contracts')
                                ->label('Contract')
                                ->maxSize(100000)
                                ->collection('contracts')
                                ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                                ->columnSpan(4)->nullable(),
//                                --
                                SpatieMediaLibraryFileUpload::make('poster_upload')
                                    ->label('Poster')
                                    ->collection('posters')
                                    ->acceptedFileTypes(['image/*'])
                                    ->maxSize(100000)
                                    ->columnSpan(4)->nullable(),
//                                --
                                /*SpatieMediaLibraryFileUpload::make('trailer_upload')
                                ->label('Trailer')
                                ->collection('trailers')
                                ->acceptedFileTypes(['video/x-msvideo', 'video/mpeg', 'video/mp4'])
                                ->maxSize(config('media-library.max_file_size'))
                                ->columnSpan(4)->nullable(),*/
//                                --

                                /*SpatieMediaLibraryFileUpload::make('hd_fil_upload')
                                ->previewable(false)
                                ->label('HD file upload')
                                ->collection('videos')
                                ->acceptedFileTypes(['video/x-msvideo', 'video/mpeg', 'video/mp4'])
                                ->maxSize(config('media-library.max_file_size'))
                                ->columnSpan(4)->nullable(),*/
//                                --
                                Select::make('sponsored_by')
                                ->hidden(function ($record) {
                                    $user = User::whereId($record?->user_id)->first();
                                    if ($user) {
                                        $role = collect($user->roles)->filter(fn($r) => $r->name == 'sponsor')->first();
                                        if ($role) {
                                            return true;
                                        }
                                    }
                                    return false;
                                })
                                ->disabled(!$can_assign_sponsor)
                                ->label('Sponsored By')
                                ->options(
                                        SponsorProfile::all()->pluck('organization_name', 'user_id')
                                )->columnSpan(3)->nullable(),
                                //--
                                Select::make('creator_id')
                                ->label('Assign Creator')
                                ->options(
                                        CreatorProfile::all()->pluck('name', 'user_id')
                                )
                                ->disabled(!$can_assign_creator)
                                ->hidden(
                                        function ($record) {
                                            $user = User::whereId($record?->user_id)->first();
                                            if ($user) {
                                                $role = collect($user->roles)->filter(fn($r) => $r->name == 'creator')->first();
                                                if ($role) {
                                                    return true;
                                                }
                                            }
                                            return false;
                                        }
                                )
                                ->columnSpan(3)->nullable(),
                                Select::make('status')
                                ->disabled(!$can_change_status)
                                ->label('Status')->options(ProposalStatus::all()->pluck('status', 'id'))
                                ->columnSpan(2)->nullable(),
                            ])->columns(8),
                        ])->statePath('data');
    }

    public static function sponsorTable(Table $table, $propsal_id = null): Table
    {
        return $table->query(PotentialSponsor::where('proposal_id', $propsal_id))
                        ->columns([
                            TextColumn::make('id')
        ]);
    }

    public static function canEdit(Model $model): bool
    {
        if (auth()->user()->hasRole('sponsor')) {
            if ($model->user_id == auth()->id()) {
                return true;
            }
        }
        if (auth()->user()->hasRole('creator')) {
            if ($model->user_id == auth()->id()) {
                return true;
            }
        }
        if (auth()->user()->hasRole(['admin', 'super_admin'])) {
            return true;
        }
        return false;
    }

    public static function canDelete(Model $model): bool
    {
        if (auth()->user()->hasRole('sponsor')) {
            if ($model->user_id == auth()->id()) {
                return true;
            }
        }
        if (auth()->user()->hasRole('creator')) {
            if ($model->user_id == auth()->id()) {
                return true;
            }
        }
        if (auth()->user()->hasRole(['admin', 'super_admin'])) {
            return true;
        }
        return false;
    }

    public static function infolistSchema()
    {
        return [
            TextEntry::make('working_title')->color('gray'),
            TextEntry::make('topics')->label('Topics')->color('gray')->default('--'),
            TextEntry::make('synopsis')->label('Synopsis')->color('gray')->columnSpanFull()->default('--'),
            TextEntry::make('film_type')->label('Film Type')->color('gray')->default('--'),
            TextEntry::make('film_rating')->label('Film Rating')->color('gray')->default('--'),
            TextEntry::make('film_budget')->label('Film Budget (KES)')->color('gray')->default('--'),
            TextEntry::make('film_length')->label('Film Length (Minutes)')->color('gray')->default('--'),
            TextEntry::make('production_time')->label('Production Time (Days)')->color('gray')->default('--'),
            TextEntry::make('user.name')->label('Created By')->color('gray')->default('--'),
            TextEntry::make('sponsorUser.name')->label('Sponsor User')->color('gray')->default('--'),
            TextEntry::make('sponsor.organization_name')->label('Sponsor Organization')->color('gray')->default('--'),
            TextEntry::make('genre.genre_name')->label('Genre')->color('gray')->default('--'),
            TextEntry::make('proposal_status.status')->label('Status')->color('gray')->default('--')
        ];
    }

    public static function tableActions()
    {
        $admins_only = auth()->user()->hasRole(['admin', 'super_admin']);
        $admins_and_sponsors = auth()->user()->hasRole(['admin', 'super_admin', 'sponsor']);

        return [
            ActionGroup::make([
                Action::make('previewTrailer')
                    ->label('Preview Trailer')
                    ->icon('heroicon-m-video-camera')
                    ->modal()
                    ->requiresConfirmation(false)
                    ->modalContent(function (CreatorProposal $proposal) {
                        /* @var $media Media */
                        $media = $proposal->getMedia('trailers')->last();
                        $video = [
                            'url' => $media?->getFullUrl(),
                            'vimeo_url' => $media?->getCustomProperty('vimeo_link'),
                            'title' => $proposal->working_title,
                            'type' => 'Trailer',
                        ];
                        return \view('filament.pages.video-preview', compact('proposal', 'video'));
                    })
                    ->modalSubmitAction(false)
                    ->modalCancelAction(false),
                Action::make('previewHdVideo')
                    ->label('Preview HD Video')
                    ->icon('heroicon-m-video-camera')
                    ->modal()
                    ->requiresConfirmation(false)
                    ->modalContent(function (CreatorProposal $proposal) {
                        $video = [
                            'url' => $proposal->getMedia('videos')->last()?->getFullUrl(),
                            'vimeo_url' => $proposal->vimeo_link,
                            'title' => $proposal->working_title,
                            'type' => 'HD Video',
                        ];
                        return \view('filament.pages.video-preview', compact('proposal', 'video'));
                    })
                    ->modalSubmitAction(false)
                    ->modalCancelAction(false),
                Action::make('downloadScript')
                    ->label('Download Script')
                    ->icon('heroicon-m-arrow-down-tray')
                    ->requiresConfirmation()
                    ->action(function (CreatorProposal $proposal) {
                        $item = $proposal->getMedia('scripts')->last();
                        return response()->download($item->getPath(), $item->file_name);
                    })
                    ->visible(function (CreatorProposal $proposal) {
                        $item = $proposal->getMedia('scripts')->last();
                        return !is_null($item) && File::exists($item->getPath());
                    }),
                Action::make('downloadContract')
                    ->label('Download Contract')
                    ->icon('heroicon-m-arrow-down-tray')
                    ->requiresConfirmation()
                    ->action(function (CreatorProposal $proposal) {
                        $item = $proposal->getMedia('contracts')->last();
                        return response()->download($item->getPath(), $item->file_name);
                    })
                    ->visible(function (CreatorProposal $proposal) {
                        $item = $proposal->getMedia('contracts')->last();
                        return !is_null($item) && File::exists($item->getPath());
                    }),
                Action::make('downloadPoster')
                    ->label('Download Poster')
                    ->icon('heroicon-m-arrow-down-tray')
                    ->requiresConfirmation()
                    ->action(function (CreatorProposal $proposal) {
                        $item = $proposal->getMedia('posters')->last();
                        return response()->download($item->getPath(), $item->file_name);
                    })
                    ->visible(function (CreatorProposal $proposal) {
                        $item = $proposal->getMedia('posters')->last();
                        return !is_null($item) && File::exists($item->getPath());
                    })
            ])->label('Preview')
                ->icon('heroicon-m-video-camera')
                ->size(ActionSize::Small)
                ->color('primary')
                ->button()
                ->visible(fn() => $admins_and_sponsors),
            Action::make('potentialSponsors')
                ->url(function ($record) {
                    return Pages\ListCreatorProposalEOI::getUrl([$record]);
                })
                ->label('Potential Sponsors')
                ->visible(fn() => $admins_only),
            Action::make('selectForFunding')
                ->action(function (CreatorProposal $record) {
                    $data = [
                        'sponsor_id' => auth()->id(),
                        'proposal_id' => $record->id
                    ];
                    $saved = PotentialSponsor::saveEOI($data, $data);

                    if ($saved) {
                        Notification::make()
                            ->success()
                            ->title('Your Expression of Interest has been submitted');
                    } else {
                        Notification::make()
                            ->warning()
                            ->title('Failed to submit Expression of Interest');
                    }
                    return;
                })
                ->visible(function (CreatorProposal $record) {
                    return auth()->user()->hasRole('sponsor') && $record->sponsored_by == null;
                })
                ->label('Select for funding'),
            ActionGroup::make([
                Tables\Actions\EditAction::make()
                    ->label('Update Project'),
                Tables\Actions\Action::make('upload-hd-video')
                    ->label('Upload HD Video')
                    ->icon('heroicon-m-arrow-up-tray')
                    ->url(function ($record) {
                        return Pages\UploadCreatorProposalHDVideo::getUrl([$record]);
                    })->visible(fn() => $admins_only),
                Tables\Actions\Action::make('upload-trailer-video')
                    ->label('Upload Trailer')
                    ->icon('heroicon-m-arrow-up-tray')
                    ->url(function ($record) {
                        return Pages\UploadCreatorProposalTrailer::getUrl([$record]);
                    })->visible(fn() => $admins_only),
                Tables\Actions\Action::make('upload_hd_to_vimeo')
                    ->visible(auth()->user()->can('upload_to_vimeo_publishing::schedule'))
                    ->requiresConfirmation(function (CreatorProposal $record) {
                        return $record->vimeo_link != null;
                    })
                    ->icon('heroicon-m-cloud-arrow-up')
                    ->label('Upload HD Video to Vimeo')
                    ->modalHeading('Overwrite Video')
                    ->modalDescription('This Film has a HD Video on vimeo. Do you want ot overwrite it?')
                    ->action(function (CreatorProposal $record): void {
                        UploadVideoToVimeo::dispatch($record, 'videos');

                        Notification::make()
                            ->title('upload has been queued')
                            ->success()
                            ->send();
                    }),
                Tables\Actions\Action::make('upload_trailer_to_vimeo')
                    ->visible(auth()->user()->can('upload_to_vimeo_publishing::schedule'))
                    ->requiresConfirmation(function (CreatorProposal $record) {
                        $proposal = $record;
                        /* @var $media Media */
                        $media = $proposal->getMedia('trailers')->last();
                        $vimeo_link = $media?->getCustomProperty('vimeo_link');
                        return !empty($vimeo_link);
                    })
                    ->icon('heroicon-m-cloud-arrow-up')
                    ->label('Upload Trailer to Vimeo')
                    ->modalHeading('Overwrite Trailer')
                    ->modalDescription('This Film has a trailer on vimeo. Do you want ot overwrite it?')
                    ->action(function (CreatorProposal $record): void {
                        UploadVideoToVimeo::dispatch($record, 'trailers');

                        Notification::make()
                            ->title('upload has been queued')
                            ->success()
                            ->send();
                    }),
                Action::make('assignCreator')
                    ->fillForm(fn (CreatorProposal $record): array => [
                        'creator_id' => $record->creator_id,
                    ])
                    ->form([
                        Select::make('creator_id')
                            ->label('Creator')
                            ->options(CreatorProfile::all()->pluck('name', 'user_id'))
                            ->required(),
                    ])
                    ->action(function (array $data, CreatorProposal $record) {
                        $assigned = $record->assignCreator($data['creator_id']);

                        if ($assigned) {
                            Notification::make()
                                ->success()
                                ->title('Creator has been assigned to this Film Proposal');
                        } else {
                            Notification::make()
                                ->warning()
                                ->title('Failed to assign Creator');
                        }
                    })
                    ->visible(function (CreatorProposal $record) use ($admins_only) {
                        return $admins_only && $record->creator_id == null;
                    })
                    ->label('Assign Creator')
                    ->icon('heroicon-m-user-plus'),
                Action::make('assignSponsor')
                    ->fillForm(fn (CreatorProposal $record): array => [
                        'sponsored_by' => $record->sponsored_by,
                    ])
                    ->form([
                        Select::make('sponsored_by')
                            ->label('Sponsor')
                            ->options(SponsorProfile::all()->pluck('organization_name', 'user_id'))
                            ->required(),
                    ])
                    ->action(function (array $data, CreatorProposal $record) {
                        $assigned = $record->assignSponsor($data['sponsored_by']);

                        if ($assigned) {
                            Notification::make()
                                ->success()
                                ->title('Sponsor has been assigned to this Film Proposal');
                        } else {
                            Notification::make()
                                ->warning()
                                ->title('Failed to assign Sponsor');
                        }
                    })
                    ->visible(function (CreatorProposal $record) use ($admins_only) {
                        return $admins_only && $record->sponsored_by == null;
                    })
                    ->label('Assign Sponsor')
                    ->icon('heroicon-o-user-plus'),
                Action::make('publishFilm')
                    ->url(function ($record) {
                        return \App\Filament\Resources\PublishingScheduleResource\Pages\CreatePublishingSchedule::getUrl(['proposal_id' => $record]);
                    })
                    ->visible(function (CreatorProposal $record) use ($admins_only) {
                        return $admins_only && !$record->is_published;
                    })
                    ->label('Publish Film')
                    ->icon('heroicon-m-clock'),
                Tables\Actions\ViewAction::make()
                    ->label('View Details')
                    ->infolist([
                        Grid::make([
                            'default' => 2
                        ])
                        ->schema(static::infolistSchema())
                    ])
                    ->fillForm(function ($record) {
                        return collect($record)->toArray();
                    }),
                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation()
                    ->visible(auth()->user()->can('delete_creator::proposal'))
            ])
            ->label('Actions')
            ->icon('heroicon-m-ellipsis-vertical')
            ->size(ActionSize::Small)
            ->color('primary')
            ->button(),
        ];
    }

    public static function table(Table $table): Table
    {
        $admins_only = auth()->user()->hasRole(['admin', 'super_admin']);

        $query = CreatorProposal::query()->with(['sponsor', 'genre', 'creator', 'assigned_creator']);
        if (auth()->user()->hasRole('creator')) {
            $query = $query->where(function ($q) {
                $q->where('user_id', auth()->id())
                        ->orwhere('creator_id', auth()->id());
            });
        }
        if (auth()->user()->hasRole('sponsor')) {
            $query = $query->where(function ($q) {
                $q->whereNull('sponsored_by');
            });
        }

        $query->orderBy('id', 'desc');

        return $table
                        ->headerActions([
                            Tables\Actions\Action::make('Export')
                            ->action(function () {
                                return Excel::download(new FilmProjectsExport(), 'fprojects.csv');
                            })
                        ])
                        ->filters([
                            SelectFilter::make('sponsored_by')
                                ->visible(function () use ($admins_only) {
                                    return $admins_only;
                                })
                                ->searchable()
                                ->preload()
                                ->label('Sponsor')
                                ->relationship('sponsor', 'organization_name'),
                            SelectFilter::make('film_genre')
                            ->relationship('genre', 'genre_name')
                            ->label('Genre'),
                            SelectFilter::make('status')
                            ->relationship('proposal_status', 'status'),
                            Filter::make('created_at')
                            ->form([
                                DatePicker::make('created_from')->label('From'),
                                DatePicker::make('created_until')->label('To'),
                            ])
                            ->columns(2)
                            ->columnSpan(2)
                            ->query(function (Builder $query, array $data): Builder {
                                return $query
                                ->when(
                                        $data['created_from'],
                                        fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                                )
                                ->when(
                                        $data['created_until'],
                                        fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                                );
                            })
                                ], layout: FiltersLayout::AboveContent)->filtersFormColumns(5)
                        ->filtersTriggerAction(
                                fn(Action $action) => $action
                                ->button()
                                ->label('Filter'),
                        )
                        ->query($query)
                        ->columns([
                            TextColumn::make('working_title')
                                ->label('Working Title'),
                            TextColumn::make('user.name')
                                ->label('Created By')
                                ->name('user.name'),
                            TextColumn::make('sponsor_user')
                                ->name('sponsorUser.name')
                                ->label('Sponsor User Name'),
                            TextColumn::make('sponsor_orgname')
                                ->name('sponsor.organization_name')
                                ->label('Sponsor Org Name'),
                            TextColumn::make('assigned_creator')
                                ->label('Assigned Creator')
                                ->name('assigned_creator.name'),
                            TextColumn::make('genre')
                                ->name('genre.genre_name'),
                            TextColumn::make('status')
                                ->label('Proposal Status')
                                ->name('proposal_status.status'),
                            TextColumn::make('created_at')
                                ->label('Date Created')
                                ->date()
                        ])
                        ->actions(static::tableActions())
                        ->bulkActions([
                            Tables\Actions\BulkActionGroup::make([
                                Tables\Actions\DeleteBulkAction::make(),
                            ]),
        ]);
    }

    public static function getRelations(): array
    {
        return [
                //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCreatorProposals::route('/'),
            'create' => Pages\CreateCreatorProposal::route('/create'),
            'edit' => Pages\EditCreatorProposal::route('/{record}/edit'),
            'manage-videos' => Pages\EditCreatorProposalVideos::route('/{record}/manage-videos'),
            'upload-hd-video' => Pages\UploadCreatorProposalHDVideo::route('/{record}/upload-video'),
            'upload-trailer' => Pages\UploadCreatorProposalTrailer::route('/{record}/upload-trailer'),
            'list-eoi' => Pages\ListCreatorProposalEOI::route('/{record}/list-eoi'),
        ];
    }

    public static function getRecordSubNavigation(\Filament\Resources\Pages\Page $page): array
    {
        return $page->generateNavigationItems([
            Pages\EditCreatorProposal::class,
            //Pages\EditCreatorProposalVideos::class,
            Pages\UploadCreatorProposalHDVideo::class,
            Pages\UploadCreatorProposalTrailer::class,
            Pages\ListCreatorProposalEOI::class,
        ]);
    }

    public function getSubNavigationParameters(): array
    {
        return [];
    }
}
