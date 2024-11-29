<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReadingResource\Pages;
use App\Models\Reading;
use App\Models\Meter; 
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Actions\Action;

class ReadingResource extends Resource
{
    protected static ?string $model = Reading::class;

    protected static ?string $navigationGroup = 'Meters Management';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
        
        ->schema([
            Select::make('meter_id')
            ->label('Meter')
            ->required()
            ->relationship('meter', 'meter_number')  
            ->searchable()
            ->options(Meter::all()->pluck('meter_number', 'id'))
            ->placeholder('Select Meter'),
        
            TextInput::make('reading_value')
                ->required()
                ->numeric()
                ->label('Reading Value (m³)')
                ->minValue(0)
                ->step(0.01)
                ->helperText('Enter the reading value in cubic meters (m³).'),

            FileUpload::make('photo')
                ->label('Photo')
                ->image()
                ->directory('uploads/readings')
                ->maxSize(2048)
                ->acceptedFileTypes(['image/jpeg', 'image/png'])
                ->nullable(),

            TextInput::make('reading_year')
                ->required()
                ->numeric()
                ->label('Year')
                ->maxLength(4),

            TextInput::make('reading_month')
                ->required()
                ->numeric()
                ->label('Month')
                ->minValue(1)
                ->maxValue(12),

            TextInput::make('reading_day')
                ->required()
                ->numeric()
                ->label('Day')
                ->minValue(1)
                ->maxValue(31),
        ])
        ->stateUpdated(function ($state, $set, $get) {
            $meterId = $get('meter_id');
            $meter = Meter::find($meterId);

            if ($meter) {
                // Set the meter_number to the selected meter's number
                $set('meter_number', $meter->meter_number);
            }
        });
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('meter_number')->label('Meter Number')->sortable(), 
                TextColumn::make('reading_value')->label('Reading Value (m³)')->sortable(),
                ImageColumn::make('photo')->label('Photo'),
                TextColumn::make('reading_year')->label('Year')->sortable(),
                TextColumn::make('reading_month')->label('Month')->sortable(),
                TextColumn::make('reading_day')->label('Day')->sortable(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReadings::route('/'),
            'create' => Pages\CreateReading::route('/create'),
            'edit' => Pages\EditReading::route('/{record}/edit'),
           
        ];
    }
}
