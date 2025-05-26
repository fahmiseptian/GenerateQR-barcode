<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Outbound') }}
        </h2>
    </x-slot>

    <div class="container py-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h2 class="h4 mb-4">Warranty Form</h2>
                <form method="POST">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="customer" class="form-label">Customer Name</label>
                            <input type="text" name="customer" id="customer" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label for="unit" class="form-label">Unit Name</label>
                            <input type="text" name="unit" id="unit" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label for="po_number" class="form-label">PO Number</label>
                            <input type="text" name="po_number" id="po-number" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label for="so_number" class="form-label">SO Number</label>
                            <input type="text" name="so_number" id="so-number" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label for="serial_number" class="form-label">Serial Number</label>
                            <input type="text" name="serial_number" id="serial-number" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label for="delivery_date" class="form-label">Delivery Date</label>
                            <input type="date" name="delivery_date" id="delivery-date" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label for="installed_date" class="form-label">Installed Date</label>
                            <input type="date" name="installed_date" id="installed-date" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label for="handover_date" class="form-label">Handover Date</label>
                            <input type="date" name="handover_date" id="handover-date" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label for="warranty_code" class="form-label">Warranty Code</label>
                            <input type="text" name="warranty_code" id="warranty_code" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label for="expired_date" class="form-label">Expired Warranty</label>
                            <select name="expired_date" id="expired-date" class="form-select" required>
                                <option value="">-- Select Duration --</option>
                                <option value="1">1 Year</option>
                                <option value="2">2 Year</option>
                                <option value="3">3 Year</option>
                                <option value="4">4 Year</option>
                                <option value="5">5 Year</option>
                            </select>
                        </div>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>

                <div class="mt-4">
                    <h4>Generated Codes</h4>
                    <div class="row mt-4">
                        <div class="col-md-6 d-flex justify-content-center align-items-center" style="height: 200px;">
                            <div class="text-center">
                                <h5>Barcode</h5>
                                @if (!empty($item))
                                <img src="{{ asset($item->barcode) }}" alt="Barcode" class="img-fluid">
                                @else
                                <div class="border p-3" id="barcode-box" style="height: 150px; display: flex; align-items: center; justify-content: center;">(Barcode here)</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6 d-flex justify-content-center align-items-center" style="height: 200px;">
                            <div class="text-center">
                                <h5>QR Code</h5>
                                @if (!empty($item))
                                <img src="{{ asset($item->qr_code) }}" alt="QR Code" class="img-fluid">
                                @else
                                <div class="border p-3" id="qrcode-box" style="height: 150px; display: flex; align-items: center; justify-content: center;">(QR Code here)</div>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if (!empty($item))
                    <div class="text-end mt-4">
                        <a href="{{ route('find.detail',['id' => $item->id]) }}" target="_blank" class="btn btn-warning">Print</a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>