<?php

namespace App\Filament\Resources\Workspace\Employee;

use Filament\Forms;
use Filament\Support\Enums\IconSize;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Support\Enums\MaxWidth;
use Filament\Support\Enums\ActionSize;
use Filament\Tables\Actions\ActionGroup;
use App\Models\Workspace\Employee\EmployeeCategory;
use App\Filament\Resources\Workspace\Employee\EmployeeCategoryResource\Pages;

class EmployeeCategoryResource extends Resource {
    protected static ?string $model = EmployeeCategory::class;

    protected static ?string $navigationGroup = 'Employee Management';

    protected static ?string $navigationLabel = 'Category';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-group';

    protected static ?int $navigationSort = 1;

    public static function form( Form $form ): Form {
        return $form
            ->schema( [
                Forms\Components\TextInput::make( 'name' )
                    ->label( 'Category Name' )
                    ->placeholder( 'Ex. Individual, Team, Agency, Company' )
                    ->required()
                    ->maxLength( 255 )
                    ->columnSpan( 'full' ),
                Forms\Components\Textarea::make( 'notes' )
                    ->maxLength( 255 )
                    ->label( 'Notes' )
                    ->helperText( 'Write notes about the category' )
                    ->placeholder( 'Additional notes about the category' )
                    ->columnSpan( 'full' ),
            ] );
    }

    public static function table( Table $table ): Table {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make( 'name' )
                    ->searchable(),
                Tables\Columns\TextColumn::make( 'notes' )
                    ->searchable(),
                Tables\Columns\TextColumn::make( 'created_at' )
                    ->dateTime()
                    ->sortable()
                    ->toggleable( isToggledHiddenByDefault: true ),
                Tables\Columns\TextColumn::make( 'updated_at' )
                    ->dateTime()
                    ->sortable()
                    ->toggleable( isToggledHiddenByDefault: true ),
            ] )
            ->filters( [
                //
            ])
            ->actions( [
                Tables\Actions\EditAction::make()
                        ->modalWidth(MaxWidth::Medium)
                        ->icon('mdi-square-edit-outline')
                        ->color('warning')
                        ->outlined()
                        ->iconButton(),
                // ActionGroup::make([
                //     Tables\Actions\EditAction::make()
                //         ->modalWidth(MaxWidth::Medium),
                // ])
                // ->icon('heroicon-m-ellipsis-vertical')
                // ->size(ActionSize::Small)
                // ->color('primary')
                // ->iconButton()
            ])
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
            'index' => Pages\ListEmployeeCategories::route( '/' ),
        ];
    }
}
