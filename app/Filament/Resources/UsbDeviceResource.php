<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UsbDeviceResource\Pages;
use App\Filament\Resources\UsbDeviceResource\RelationManagers;
use App\Models\UsbDevice;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UsbDeviceResource extends Resource
{
    protected static ?string $model = UsbDevice::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('busNumber')
                    ->numeric(),
                Forms\Components\TextInput::make('deviceAddress')
                    ->numeric(),
                Forms\Components\TextInput::make('vendorId')
                    ->numeric(),
                Forms\Components\TextInput::make('productId')
                    ->numeric(),
                Forms\Components\TextInput::make('macAddress')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('busNumber')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('deviceAddress')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('vendorId')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('productId')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('macAddress')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListUsbDevices::route('/'),
            'create' => Pages\CreateUsbDevice::route('/create'),
            'edit' => Pages\EditUsbDevice::route('/{record}/edit'),
        ];
    }
}
