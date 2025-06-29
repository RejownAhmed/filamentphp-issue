<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class UserResource extends Resource {
    protected static ?string $model = User::class;

    protected static ?string $navigationGroup = 'Filament Shield';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 11;

    protected static ?string $tenantOwnershipRelationshipName = 'teams';

    public static function form( Form $form ): Form {
        return $form
            ->schema( [
                Forms\Components\TextInput::make( 'name' )
                    ->required()
                    ->maxLength( 255 ),
                Forms\Components\TextInput::make( 'email' )
                    ->email()
                    ->required()
                    ->maxLength( 255 ),
                Forms\Components\DateTimePicker::make( 'email_verified_at' ),
                Forms\Components\TextInput::make( 'password' )
                    ->label( 'Password' )
                    ->password()
                    ->maxLength( 255 )
                    ->dehydrateStateUsing( fn( $state ) => filled( $state ) ? bcrypt( $state ) : null )
                    ->required( fn( string $context ) => $context === 'create' )
                    ->dehydrated( fn( $state ) => filled( $state ) ) // only save when filled
                    ->autocomplete( 'new-password' ),
                Forms\Components\CheckboxList::make( 'roles' )
                    ->relationship( name: 'roles', titleAttribute: 'name' )
                    ->saveRelationshipsUsing( function ( User $record, $state ) {
                        $record->roles()->syncWithPivotValues( $state, [config( 'permission.column_names.team_foreign_key' ) => getPermissionsTeamId()] );
                    } )
                    ->searchable(),
            ] );
    }

    public static function table( Table $table ): Table {
        return $table
            ->columns( [
                Tables\Columns\TextColumn::make( 'name' )
                    ->searchable(),
                Tables\Columns\TextColumn::make( 'email' )
                    ->searchable(),
                Tables\Columns\TextColumn::make( 'email_verified_at' )
                    ->dateTime()
                    ->sortable(),
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
                Tables\Actions\EditAction::make(),
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
            'index'  => Pages\ListUsers::route( '/' ),
            'create' => Pages\CreateUser::route( '/create' ),
            'edit'   => Pages\EditUser::route( '/{record}/edit' ),
        ];
    }
}
