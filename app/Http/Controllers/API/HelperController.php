<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HelperController extends Controller
{
    public function mac()
    {
        // Specify the file path
        $filePath = 'E:\mac.txt';

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

                // Encrypt the MAC address using SHA-256
                $encryptedMac = hash('sha256', $macAddress);

                // Check if the encrypted MAC address is not already in the file
                if (!in_array($encryptedMac, $existingMacAddresses)) {
                    // Append the encrypted MAC address to the file
                    file_put_contents($filePath, $encryptedMac . PHP_EOL, FILE_APPEND);

                    // Add the new encrypted MAC address to the array of existing MAC addresses
                    $existingMacAddresses[] = $encryptedMac;
                }
            }
        }
    }

    public function mac_validation()
    {
        foreach (request()->all() as $key => $value) {
            if (isset($value['mac'])) {
                $macAddress = $value['mac'];
                $encryptedMac = hash('sha256', $macAddress); // Encrypt the provided MAC address using SHA-256

                $validationResult = $this->validateMacAddress($encryptedMac);

                // Return the validation result as JSON
                return response()->json(['is_valid' => $validationResult['is_valid'], 'msg' => $validationResult['msg']]);
            }
        }
    }

    private function validateMacAddress($encryptedMac)
    {
        // Validate MAC address format
        if (!preg_match('/^[0-9a-f]{64}$/', $encryptedMac)) {
            return ['is_valid' => false, 'msg' => 'Invalid encrypted MAC address format'];
        }

        // Specify the file path for the stored encrypted MAC addresses
        $filePath = 'E:\mac.txt';

        // Check if the file exists
        if (file_exists($filePath)) {
            // Read existing encrypted MAC addresses from the file
            $existingEncryptedMacs = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

            // Check if the encrypted MAC address is in the file
            if (in_array($encryptedMac, $existingEncryptedMacs)) {
                return ['is_valid' => true, 'msg' => 'Encrypted MAC address is valid and stored'];
            } else {
                return ['is_valid' => false, 'msg' => 'Encrypted MAC address not found'];
            }
        } else {
            // If the file doesn't exist, encrypted MAC address is not valid
            return ['is_valid' => false, 'msg' => 'Encrypted MAC address not found'];
        }
    }
}
