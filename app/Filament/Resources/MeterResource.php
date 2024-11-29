<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MeterResource\Pages;
use App\Filament\Resources\MeterResource\RelationManagers;
use App\Models\Meter;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MeterResource extends Resource
{
    protected static ?string $model = Meter::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\Select::make('customer_id')
                ->label('Customer')
                ->required()
                ->relationship('customer', 'name') // Assuming 'name' is a field in the customers table
                ->searchable()
                ->preload(),
            Forms\Components\TextInput::make('meter_number')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('address')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('postCode')
                ->required()
                ->maxLength(255),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            Tables\Columns\TextColumn::make('customer.name') // Display customer name
                ->label('Customer')
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('meter_number')
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('address')
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('postCode')
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('created_at')
                ->sortable()
                ->dateTime(),
        ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
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
            'index' => Pages\ListMeters::route('/'),
            'create' => Pages\CreateMeter::route('/create'),
            'edit' => Pages\EditMeter::route('/{record}/edit'),
        ];
    }
}
