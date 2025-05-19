<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="container py-4">
        <div class="card shadow-sm">
            <div class="card-body" id="print-section">
                <h2 class="h4 mb-4">Detail Warranty</h2>
                <form method="POST">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="warranty_code" class="form-label">Warranty Code</label>
                            <input type="text" name="warranty_code" value="{{ $item->warranty_code }}" id="warranty_code" class="form-control" readonly required>
                        </div>

                        <div class="col-md-6">
                            <label for="unit" class="form-label">Unit</label>
                            <input type="text" name="unit" value="{{ $item->unit}}" id="unit" class="form-control" readonly required>
                        </div>

                        <div class="col-md-6">
                            <label for="serial_number" class="form-label">Serial Number</label>
                            <input type="text" name="serial_number" value="{{ $item->serial_number }}" id="serial-number" class="form-control" readonly required>
                        </div>

                        <div class="col-md-6">
                            <label for="expired_date" class="form-label">Expired Date</label>
                            <input type="date" name="expired_date" value="{{ $item->expired_date}}" id="expired-date" class="form-control" readonly required>
                        </div>

                        <div class="col-md-6">
                            <label for="customer" class="form-label">Customer</label>
                            <input type="text" name="customer" value="{{ $item->customer}}" id="customer" class="form-control" readonly required>
                        </div>

                        <div class="col-md-6">
                            <label for="po_number" class="form-label">PO Number</label>
                            <input type="text" name="po_number" value="{{ $item->po_number}}" id="po-number" class="form-control" readonly required>
                        </div>

                        <div class="col-md-6">
                            <label for="so_number" class="form-label">SO Number</label>
                            <input type="text" name="so_number" id="so-number" value="{{ $item->so_number}}" class="form-control" readonly required>
                        </div>

                        <div class="col-md-6">
                            <label for="delivery_date" class="form-label">Delivery Date</label>
                            <input type="date" name="delivery_date" value="{{ $item->delivery_date }}" id="delivery-date" class="form-control" readonly required>
                        </div>

                        <div class="col-md-6">
                            <label for="installed_date" class="form-label">Installed Date</label>
                            <input type="date" name="installed_date" value="{{ $item->installed_date }}" id="installed-date" class="form-control" readonly required>
                        </div>

                        <div class="col-md-6">
                            <label for="handover_date" class="form-label">Handover Date</label>
                            <input type="date" name="handover_date" value="{{ $item->handover_date }}" id="handover-date" class="form-control" readonly required>
                        </div>
                    </div>
                </form>


                <div class="mt-4">
                    <h4>Generated Codes</h4>
                    <div class="row mt-4">
                        <div class="col-md-6 d-flex justify-content-center align-items-center" style="height: 200px;">
                            <div class="text-center">
                                <h5 class="mb-4">Barcode</h5>
                                @if (!empty($item))
                                <img src="{{ asset($item->barcode) }}" alt="Barcode" class="img-fluid">
                                @else
                                <div class="border p-3" id="barcode-box" style="height: 150px; display: flex; align-items: center; justify-content: center;">(Barcode here)</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6 d-flex justify-content-center align-items-center" style="height: 200px;">
                            <div class="text-center">
                                <h5 class="mb-4">QR Code</h5>
                                @if (!empty($item))
                                <img src="{{ asset($item->qr_code) }}" alt="QR Code" class="img-fluid">
                                @else
                                <div class="border p-3" id="qrcode-box" style="height: 150px; display: flex; align-items: center; justify-content: center;">(QR Code here)</div>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="d-flex justify-content-between m-4">
                <button onclick="printWarranty()" class="btn btn-primary">Print Detail</button>
                <button onclick="printcode()" class="btn btn-primary">Print QR & Barcode</button>
            </div>
        </div>
    </div>

    <script>
        function printWarranty() {
            var printContent = document.getElementById('print-section').innerHTML;
            var originalContent = document.body.innerHTML;

            document.body.innerHTML = printContent;
            window.print();
            document.body.innerHTML = originalContent;
        }

        function printcode() {
            const id = "{{ $item->id }}";
            const url = `{{ route('find.print') }}?idArr[]=${id}`;
            window.open(url, '_blank');
        }
    </script>
</x-app-layout>