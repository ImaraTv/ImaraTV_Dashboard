<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class UserManual extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.user-manual';

    protected static ?string $title = 'User Manual';

    protected static ?int $navigationSort = 7;
}
