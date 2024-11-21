<?php

namespace App\Filament\Pages;

use App\Filament\Resources\CreatorProposalResource;
use App\Models\CreatorProposal;
use App\Models\PotentialSponsor;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Enums\ActionSize;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Support\Facades\File;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class SponsorFilmProjects extends Page implements HasTable
{
    use InteractsWithTable,
        HasPageShield;

    protected static string $resource = CreatorProposalResource::class;
    protected static ?string $slug = 'my-film-projects';
    protected static ?string $modelLabel = 'Film Project';
    protected static string $view = 'filament.pages.sponsor-film-projects';
    protected static ?string $navigationIcon = 'heroicon-s-film';
    protected static ?string $navigationLabel = 'My Film Projects';
    protected static ?string $title = 'My Film Projects';
    protected static ?int $navigationSort = 3;

    #[\Override]
    public static function canAccess(array $parameters = []): bool
    {
        return boolval(auth()->user()->approved) && auth()->user()->hasRole('sponsor');
    }

    protected function getHeaderActions(): array
    {
        return [
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
            ActionGroup::make([
                ViewAction::make()
                    ->label('View Details')
                    ->infolist([
                        Grid::make([
                            'default' => 2
                        ])
                        ->schema(CreatorProposalResource::infolistSchema())
                    ])
                    ->fillForm(function ($record) {
                        return collect($record)->toArray();
                    }),
            ])
                ->label('Actions')
                ->icon('heroicon-m-ellipsis-vertical')
                ->size(ActionSize::Small)
                ->color('primary')
                ->button(),
        ];
    }

    protected static function table(Table $table): Table {

        $query = CreatorProposal::query()->with(['sponsor', 'sponsorUser', 'genre', 'creator', 'assigned_creator']);

        if (auth()->user()->hasRole('sponsor')) {
            $query = $query->where(function ($q) {
                $q->where('sponsored_by', auth()->id());
            });
        }

        $query->orderBy('id', 'desc');

        return $table
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
            ])->actions(static::tableActions());
    }
}
