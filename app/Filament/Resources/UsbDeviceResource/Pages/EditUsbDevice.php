<?php

namespace App\Filament\Resources\UsbDeviceResource\Pages;

use App\Filament\Resources\UsbDeviceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUsbDevice extends EditRecord
{
    protected static string $resource = UsbDeviceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
