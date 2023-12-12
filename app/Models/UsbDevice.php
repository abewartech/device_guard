<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsbDevice extends Model
{
    public $table = 'usb_devices';

    public $fillable = [
        'busNumber',
        'deviceAddress',
        'vendorId',
        'productId',
        'macAddress'
    ];

    protected $casts = [
        'macAddress' => 'string'
    ];

    public static array $rules = [
        'busNumber' => 'nullable',
        'deviceAddress' => 'nullable',
        'vendorId' => 'nullable',
        'productId' => 'nullable',
        'macAddress' => 'nullable|string|max:255',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    
}
