<?php

namespace App\Filament\Resources\Workspace\Employee;

use App\Filament\Resources\Workspace\Employee\EmploymentTypeResource\Pages;
use App\Models\Workspace\Employee\EmploymentType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables;
use Filament\Tables\Table;

class EmploymentTypeResource extends Resource {
    protected static ?string $model = EmploymentType::class;

    protected static ?string $navigationGroup = 'Employee Management';

    protected static ?string $navigationLabel = 'Employment Type';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 2;

    public static function form( Form $form ): Form {
        return $form
            ->schema( [
                Forms\Components\TextInput::make( 'name' )
                    ->required()
                    ->maxLength( 255 )
                    ->placeholder( 'Ex. Full-Time, Part-Time, Contract' )
                    ->columnSpan( 'full' ),
                Forms\Components\Textarea::make( 'notes' )
                    ->maxLength( 255 )
                    ->placeholder( 'Additional notes about the employment type' )
                    ->columnSpan( 'full' ),
            ] );
    }

    public static function table( Table $table ): Table {
        return $table
            ->columns( [
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
            ] )
            ->actions( [
                Tables\Actions\EditAction::make()
                        ->modalWidth(MaxWidth::Medium)
                        ->icon('mdi-square-edit-outline')
                        ->color('warning')
                        ->outlined()
                        ->iconButton(),
                // Tables\Actions\DeleteAction::make()
                //         ->modalWidth(MaxWidth::Medium)
                //         ->icon('mdi-trash-can-outline')
                //         ->color('danger')
                //         ->outlined()
                //         ->iconButton(),
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
            'index' => Pages\ListEmploymentTypes::route( '/' ),
        ];
    }
}
