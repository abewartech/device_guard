<?php

namespace App\Repositories;

use App\Models\UsbDevice;
use App\Repositories\BaseRepository;

class UsbDeviceRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'busNumber',
        'deviceAddress',
        'vendorId',
        'productId',
        'macAddress'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return UsbDevice::class;
    }
}
