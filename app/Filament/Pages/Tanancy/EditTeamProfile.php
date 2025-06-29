<?php

namespace App\Filament\Pages\Tenancy;

use Filament\Forms\Form;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Tenancy\EditTenantProfile;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

class EditTeamProfile extends EditTenantProfile
{
    public static function getLabel(): string
    {
        return 'Team profile';
    }

public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Team Information')
                    ->description('Update details about your team.')
                    ->columns(1)
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('logo')
                            ->collection('logo')
                            ->maxSize(1024)
                            ->image(),
                        TextInput::make('name'),
                        TextInput::make('slug')
                            ->unique(ignoreRecord: true)
                            ->required()
                            ->maxLength(255)
                            ->label('Slug')
                            ->helperText('This will be used in the URL to access your team.'),
                ]),
            ]);
    }
}
