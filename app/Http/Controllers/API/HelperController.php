<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HelperController extends Controller
{
    public function mac()
    {
        // Specify the file path
        $filePath = 'D:\mac.txt';

        // Check if the file exists
        if (file_exists($filePath)) {
            // Read existing MAC addresses from the file
            $existingMacAddresses = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        } else {
            // If the file doesn't exist, create an empty array
            $existingMacAddresses = [];
        }

        foreach (request()->all() as $key => $value) {
            if (isset($value['mac'])) {
                $macAddress = $value['mac'];

                // Check if the MAC address is not already in the file
                if (!in_array($macAddress, $existingMacAddresses)) {
                    // Append the MAC address to the file
                    file_put_contents($filePath, $macAddress . PHP_EOL, FILE_APPEND);

                    // Add the new MAC address to the array of existing MAC addresses
                    $existingMacAddresses[] = $macAddress;
                }
            }
        }
    }
}
