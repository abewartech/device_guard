<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateUsbDeviceAPIRequest;
use App\Http\Requests\API\UpdateUsbDeviceAPIRequest;
use App\Models\UsbDevice;
use App\Repositories\UsbDeviceRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class UsbDeviceAPIController
 */
class UsbDeviceAPIController extends AppBaseController
{
    private UsbDeviceRepository $usbDeviceRepository;

    public function __construct(UsbDeviceRepository $usbDeviceRepo)
    {
        $this->usbDeviceRepository = $usbDeviceRepo;
    }

    /**
     * Display a listing of the UsbDevices.
     * GET|HEAD /usb-devices
     */
    public function index(Request $request): JsonResponse
    {
        $usbDevices = $this->usbDeviceRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($usbDevices->toArray(), 'Usb Devices retrieved successfully');
    }

    /**
     * Store a newly created UsbDevice in storage.
     * POST /usb-devices
     */
    public function store(CreateUsbDeviceAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        // Assuming the USB devices are in an array named 'usbDevices' in the input
        if (is_array($input)) {
            foreach ($input as $usbDeviceInfo) {
                // Check if required keys exist in the USB device info
                if (
                    isset($usbDeviceInfo['busNumber']) &&
                    isset($usbDeviceInfo['deviceAddress']) &&
                    isset($usbDeviceInfo['deviceDescriptor']['idVendor']) &&
                    isset($usbDeviceInfo['deviceDescriptor']['idProduct'])
                ) {
                    // Create a new UsbDevice model instance and save it to the database
                    $usbDevice = UsbDevice::updateOrCreate([
                        'productId' => $usbDeviceInfo['deviceDescriptor']['idProduct']
                    ], [
                        'busNumber' => $usbDeviceInfo['busNumber'],
                        'deviceAddress' => $usbDeviceInfo['deviceAddress'],
                        'vendorId' => $usbDeviceInfo['deviceDescriptor']['idVendor'],
                    ]);
                }
            }

            foreach ($input as $key => $value) {


                if (isset($value['mac'])) {
                    $usbDevice = UsbDevice::updateOrCreate([
                        'macAddress' => $value['mac']
                    ]);
                }
            }

            return $this->sendResponse([], 'Usb Devices saved successfully');
        } else {

            return $this->sendResponse([], 'Usb Devices saved successfully');
        }
    }

    /**
     * Display the specified UsbDevice.
     * GET|HEAD /usb-devices/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var UsbDevice $usbDevice */
        $usbDevice = $this->usbDeviceRepository->find($id);

        if (empty($usbDevice)) {
            return $this->sendError('Usb Device not found');
        }

        return $this->sendResponse($usbDevice->toArray(), 'Usb Device retrieved successfully');
    }

    /**
     * Update the specified UsbDevice in storage.
     * PUT/PATCH /usb-devices/{id}
     */
    public function update($id, UpdateUsbDeviceAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var UsbDevice $usbDevice */
        $usbDevice = $this->usbDeviceRepository->find($id);

        if (empty($usbDevice)) {
            return $this->sendError('Usb Device not found');
        }

        $usbDevice = $this->usbDeviceRepository->update($input, $id);

        return $this->sendResponse($usbDevice->toArray(), 'UsbDevice updated successfully');
    }

    /**
     * Remove the specified UsbDevice from storage.
     * DELETE /usb-devices/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var UsbDevice $usbDevice */
        $usbDevice = $this->usbDeviceRepository->find($id);

        if (empty($usbDevice)) {
            return $this->sendError('Usb Device not found');
        }

        $usbDevice->delete();

        return $this->sendSuccess('Usb Device deleted successfully');
    }
}
