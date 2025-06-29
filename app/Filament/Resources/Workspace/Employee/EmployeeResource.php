<?php

namespace App\Filament\Resources\Workspace\Employee;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Facades\Filament;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Support\Enums\MaxWidth;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Infolists\Components\Tabs;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Workspace\Employee\Employee;
use Filament\Infolists\Components\Tabs\Tab;
use Filament\Infolists\Components\TextEntry;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;
use App\Models\Workspace\Employee\EmploymentType;
use Filament\Infolists\Components\RepeatableEntry;
use App\Models\Workspace\Employee\EmployeeCategory;
use Ysfkaya\FilamentPhoneInput\Infolists\PhoneEntry;
use Ysfkaya\FilamentPhoneInput\PhoneInputNumberType;
use Filament\Forms\Components\Section as FormSection;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Infolists\Components\Section as InfolistSection;
use App\Filament\Resources\Workspace\Employee\EmployeeResource\Pages;

class EmployeeResource extends Resource {
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon  = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'Employee Management';
    protected static ?int $navigationSort     = 0;

    public static function getEloquentQuery(): Builder {
        return parent::getEloquentQuery()->with( ['tasks', 'expenses', 'projects'] );
    }

    public static function infolist( Infolist $infolist ): Infolist {
        return $infolist->schema( [
            InfolistSection::make( 'Contact Info' )
                ->description( 'Contact information about the employee' )
                ->schema( [
                    TextEntry::make( 'name' ),
                    TextEntry::make( 'designation' ),
                    TextEntry::make( 'email' ),
                    PhoneEntry::make( 'phone_number' )->displayFormat( PhoneInputNumberType::NATIONAL ),
                    TextEntry::make( 'address' ),
                ] )->columns( 2 )->columnSpan( ['lg' => 8] ),

            InfolistSection::make( 'Basic Employee Info' )
                ->description( 'Basic information about the employee' )
                ->schema( [
                    // SpatieMediaLibraryImageColumn::make( 'avatar' )
                    //     ->collection( 'avatar' )
                    //     ->label( 'Avatar' )
                    //     ->defaultImageUrl( asset( 'images/profile-placeholder-square.jpg' ) ),

                    TextEntry::make( 'employmentType.name' )->label( 'Employment Type' ),
                    TextEntry::make( 'employmentCategory.name' )->label( 'Employment Category' ),
                    TextEntry::make( 'join_date' )->date(),
                    TextEntry::make( 'notes' )->label( 'Notes' )->hidden( fn( $record ) => blank( $record->notes ) ),
                ] )->columnSpan( ['lg' => 8] ),
            Tabs::make( 'Related Info' )
                ->tabs( [
                    Tab::make( 'Tasks' )
                        ->schema( [
                            RepeatableEntry::make( 'tasks' )
                                ->label( 'Tasks' )
                                ->schema( [
                                    TextEntry::make( 'title' ),
                                    TextEntry::make( 'status_id' )
                                        ->badge(),
                                    TextEntry::make( 'priority' )
                                        ->badge(),
                                    TextEntry::make( 'project.name' )
                                        ->label( 'Project' ),
                                    TextEntry::make( 'due_date' )->date(),
                                ] )
                                ->columns( 6 )
                                ->visible( fn( $record ) => $record->tasks->isNotEmpty() ),

                            TextEntry::make( 'no_tasks' )
                                ->label( 'No tasks assigned.' )
                                ->visible( fn( $record ) => $record->tasks->isEmpty() ),
                        ] ),

                    Tab::make( 'Expenses' )
                        ->schema( [
                            RepeatableEntry::make( 'expenses' )
                                ->label( 'Expenses' )
                                ->schema( [
                                    TextEntry::make( 'title' ),
                                    TextEntry::make( 'amount' ),
                                    TextEntry::make( 'payment_method' ),
                                    TextEntry::make( 'category.name' ),
                                    TextEntry::make( 'project.name' )
                                        ->label( 'Project' ),
                                    TextEntry::make( 'date' )->date(),
                                ] )
                                ->columns( 6 )
                                ->visible( fn( $record ) => $record->expenses->isNotEmpty() ),

                            TextEntry::make( 'no_expenses' )
                                ->label( 'No expenses recorded.' )
                                ->visible( fn( $record ) => $record->expenses->isEmpty() ),
                        ] ),
                ] )->columnSpan( ['lg' => 8] ),
        ] );
    }

    public static function form( Form $form ): Form {
        return $form
            ->schema( [
                FormSection::make( 'Contact Info' )
                    ->description( 'Contact information about the employee' )
                    ->schema( [
                        TextInput::make( 'name' )
                            ->label( 'Employee Name' )
                            ->placeholder( 'Ex. John Doe' )
                            ->maxLength( 255 )
                            ->required(),
                        TextInput::make( 'designation' )
                            ->label( 'Designation' )
                            ->placeholder( 'Ex. Software Engineer' )
                            ->required()
                            ->maxLength( 255 ),
                        TextInput::make( 'email' )
                            ->label( 'Email Address' )
                            ->placeholder( 'Ex. someone@example.com' )
                            ->email()
                            ->maxLength( 255 ),
                        PhoneInput::make( 'phone_number' )
                            ->countryStatePath( 'phone_country' ),
                        Textarea::make( 'address' )
                            ->label( 'Address' )
                            ->placeholder( 'Ex. 123 Main St, City, Country' )
                            ->maxLength( 255 )
                            ->columnSpanFull(),
                        RichEditor::make( 'notes' )
                            ->label( 'Notes' )
                            ->placeholder( 'Additional notes about the employee' )
                            ->columnSpanFull(),
                    ] )->columns( 2 )->columnSpan( [
                    "lg" => 8,
                ] ),
                FormSection::make( 'Basic Employee Info' )
                    ->description( 'Basic information about the employee' )
                    ->schema( [
                        SpatieMediaLibraryFileUpload::make( 'profile_picture' )
                            ->collection( 'profile_picture' )
                            ->image(),
                        Select::make( 'employment_type_id' )
                            ->relationship("employmentType", "name")
                            ->native( false )
                            ->required()
                            ->preload()
                            ->searchable()
                            ->createOptionForm(fn(Form $form) => $form->schema([
                                TextInput::make('name')
                                    ->label('Employment Type')
                                    ->placeholder('Ex. Full Time')
                                    ->required()
                                    ->maxLength(255),
                                Textarea::make('notes')
                                    ->label('Notes')
                                    ->maxLength(255)
                                    ->placeholder('Additional notes about the employment type'),
                            ]))
                            ->createOptionAction(fn($action) => $action->modalWidth('sm')),
                        Select::make( 'employee_category_id' )
                            ->relationship("employeeCategory", "name")
                            ->native( false )
                            ->required()
                            ->preload()
                            ->searchable()
                            ->createOptionForm( fn( Form $form ) => $form
                                ->schema( [
                                        TextInput::make( 'name' )
                                            ->required()
                                            ->maxLength( 255 ),
                                        Textarea::make( 'notes' )
                                            ->maxLength( 255 )
                                            ->placeholder( 'Additional notes about the employment category' ),
                                ])
                        )->createOptionAction(fn($action) => $action->modalWidth('sm')),
                        DatePicker::make( 'join_date' )
                            ->label( 'Join Date' )
                            ->placeholder( 'Select the join date' )
                            ->native( false )
                            ->minDate( now()->subYears( 10 ) )
                            ->maxDate( now() )
                            ->required(),
                    ] )->columnSpan( [
                    "lg" => 4,
                ] ),
            ] )->columns( 12 );
    }

    public static function table( Table $table ): Table {
        return $table
            ->columns( [
                SpatieMediaLibraryImageColumn::make( 'avatar' )
                    ->collection( 'avatar' )
                    ->label( 'Avatar' )
                    ->defaultImageUrl( asset( 'images/profile-placeholder-square.jpg' ) ),
                TextColumn::make( 'name' )
                    ->label( 'Name' )
                    ->searchable()
                    ->sortable(),
                TextColumn::make( 'designation' )
                    ->searchable(),
                TextColumn::make( 'employmentType.name' )
                    ->label( 'Type' )
                    ->searchable(),
                TextColumn::make( 'employeeCategory.name' )
                    ->label( 'Category' )
                    ->searchable(),
                TextColumn::make( 'email' )
                    ->searchable(),
                TextColumn::make( 'phone_country' )
                    ->searchable(),
                TextColumn::make( 'phone_number' )
                    ->searchable(),
                TextColumn::make( 'join_date' )
                    ->date()
                    ->sortable(),
                TextColumn::make( 'address' )
                    ->searchable()
                    ->toggleable( isToggledHiddenByDefault: true ),
                TextColumn::make( 'created_at' )
                    ->dateTime()
                    ->sortable()
                    ->toggleable( isToggledHiddenByDefault: true ),
                TextColumn::make( 'updated_at' )
                    ->dateTime()
                    ->sortable()
                    ->toggleable( isToggledHiddenByDefault: true ),
            ] )
            ->filters( [
                //
            ] )
            ->actions( [
                Tables\Actions\ViewAction::make()
                ->modalWidth(MaxWidth::Medium)
                        ->icon('mdi-eye-outline')
                        ->color('info')
                        ->outlined()
                        ->iconButton(),
                Tables\Actions\EditAction::make()
                        ->modalWidth(MaxWidth::Medium)
                        ->icon('mdi-square-edit-outline')
                        ->color('warning')
                        ->outlined()
                        ->iconButton(),
                Tables\Actions\DeleteAction::make()
                ->modalWidth(MaxWidth::Medium)
                        ->icon('mdi-trash-can-outline')
                        ->color('danger')
                        ->outlined()
                        ->iconButton(),
            ] )
            ->bulkActions( [
                Tables\Actions\BulkActionGroup::make( [
                    Tables\Actions\DeleteBulkAction::make(),
                ] ),
            ] );
    }

    public static function getRelations(): array {
        return [
            //
        ];
    }

    public static function getPages(): array {
        return [
            'index'  => Pages\ListEmployees::route( '/' ),
            'create' => Pages\CreateEmployee::route( '/create' ),
            'view'   => Pages\ViewEmployee::route( '/{record}' ),
            'edit'   => Pages\EditEmployee::route( '/{record}/edit' ),
        ];
    }
}
