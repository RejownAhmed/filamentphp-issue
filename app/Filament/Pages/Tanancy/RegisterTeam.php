<?php
namespace App\Filament\Pages\Tenancy;

use App\Models\Team;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Tenancy\RegisterTenant;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

class RegisterTeam extends RegisterTenant
{
    public static function getLabel(): string
    {
        return 'Register team';

    }

    public function form(Form $form): Form
    {
        return $form
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
            ]);
    }

    protected function afterRegister()
    {
        // Attach the current user as the owner of the team
        $this->tenant->users()->attach(auth()->user()->id);
        // Seed default data for the created tenant
        $this->tenant->seedDefaultData();

    }
}
