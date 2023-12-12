<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUsbDeviceRequest;
use App\Http\Requests\UpdateUsbDeviceRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\UsbDeviceRepository;
use Illuminate\Http\Request;
use Flash;

class UsbDeviceController extends AppBaseController
{
    /** @var UsbDeviceRepository $usbDeviceRepository*/
    private $usbDeviceRepository;

    public function __construct(UsbDeviceRepository $usbDeviceRepo)
    {
        $this->usbDeviceRepository = $usbDeviceRepo;
    }

    /**
     * Display a listing of the UsbDevice.
     */
    public function index(Request $request)
    {
        $usbDevices = $this->usbDeviceRepository->paginate(10);

        return view('usb_devices.index')
            ->with('usbDevices', $usbDevices);
    }

    /**
     * Show the form for creating a new UsbDevice.
     */
    public function create()
    {
        return view('usb_devices.create');
    }

    /**
     * Store a newly created UsbDevice in storage.
     */
    public function store(CreateUsbDeviceRequest $request)
    {
        $input = $request->all();

        $usbDevice = $this->usbDeviceRepository->create($input);

        Flash::success('Usb Device saved successfully.');

        return redirect(route('usbDevices.index'));
    }

    /**
     * Display the specified UsbDevice.
     */
    public function show($id)
    {
        $usbDevice = $this->usbDeviceRepository->find($id);

        if (empty($usbDevice)) {
            Flash::error('Usb Device not found');

            return redirect(route('usbDevices.index'));
        }

        return view('usb_devices.show')->with('usbDevice', $usbDevice);
    }

    /**
     * Show the form for editing the specified UsbDevice.
     */
    public function edit($id)
    {
        $usbDevice = $this->usbDeviceRepository->find($id);

        if (empty($usbDevice)) {
            Flash::error('Usb Device not found');

            return redirect(route('usbDevices.index'));
        }

        return view('usb_devices.edit')->with('usbDevice', $usbDevice);
    }

    /**
     * Update the specified UsbDevice in storage.
     */
    public function update($id, UpdateUsbDeviceRequest $request)
    {
        $usbDevice = $this->usbDeviceRepository->find($id);

        if (empty($usbDevice)) {
            Flash::error('Usb Device not found');

            return redirect(route('usbDevices.index'));
        }

        $usbDevice = $this->usbDeviceRepository->update($request->all(), $id);

        Flash::success('Usb Device updated successfully.');

        return redirect(route('usbDevices.index'));
    }

    /**
     * Remove the specified UsbDevice from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $usbDevice = $this->usbDeviceRepository->find($id);

        if (empty($usbDevice)) {
            Flash::error('Usb Device not found');

            return redirect(route('usbDevices.index'));
        }

        $this->usbDeviceRepository->delete($id);

        Flash::success('Usb Device deleted successfully.');

        return redirect(route('usbDevices.index'));
    }
}
