<x-app-layout>

    <x-slot name="header">

        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">

            {{ __('Detail') }}

        </h2>

    </x-slot>



    <div class="container py-4">

        <div class="card shadow-sm">

            <div class="card-body" id="print-section">

                <h2 class="h4 mb-4">Detail Warranty</h2>

                <form method="POST">

                    <div class="row mb-3">

                        <div class="col-md-6">
                            <label for="customer" class="form-label">Customer Name</label>
                            <input type="text" name="customer" value="{{ $item->customer}}" id="customer" class="form-control" readonly required>
                        </div>

                        <div class="col-md-6">
                            <label for="unit" class="form-label">Unit Name</label>
                            <input type="text" name="unit" value="{{ $item->unit}}" id="unit" class="form-control" readonly required>
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
                            <label for="serial_number" class="form-label">Serial Number</label>
                            <input type="text" name="serial_number" value="{{ $item->serial_number }}" id="serial-number" class="form-control" readonly required>
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

                        <div class="col-md-6">
                            <label for="warranty_code" class="form-label">Warranty Code</label>
                            <input type="text" name="warranty_code" value="{{ $item->warranty_code }}" id="warranty_code" class="form-control" readonly required>
                        </div>

                        <div class="col-md-6">
                            <label for="expired_date" class="form-label">Expired Warranty</label>
                            <input type="date" name="expired_date" value="{{ $item->expired_date}}" id="expired-date" class="form-control" readonly required>
                        </div>
                        @if (!empty($item->data) && is_array(json_decode($item->data, true)))
                        @foreach (json_decode($item->data, true) as $label => $value)
                        <div class="col-md-6">
                            <label class="form-label">{{ $label }}</label>
                            <input type="text" class="form-control" value="{{ $value }}" readonly>
                        </div>
                        @endforeach
                        @endif

                    </div>

                </form>





                <div class="mt-4 mb-4">

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
                <div class="mt-4 mb-4">
                    <h4>Notes</h4>
                    @if( !empty(Auth::user()->name))
                    <div class="d-flex justify-content-between m-4">
                        <a href="{{ route('note', ['id' => $item->id]) }}" class="btn btn-primary">Add Note</a>
                    </div>
                    @endif
                    <div class="mt-4 row">
                        @forelse($item->notes as $note)
                        <div class="col-md-6 mb-3">
                            <div class="card shadow-sm">
                                @if( !empty(Auth::user()->name))
                                <div class="card-header text-end">
                                    <a onclick="return confirm('Are you sure?')" href="{{ route('note.delete',['id' => $item->id,'note_id' => $note->id]) }}" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></a>
                                </div>
                                @endif

                                <div class="card-body">
                                    <h5 class="card-title">{{ $note->title }}</h5>
                                    <p class="card-text">{{ $note->content }}</p>
                                    <small class="text-muted">{{ $note->created_at->format('d M Y H:i') }}</small>
                                    <small class="text-muted">{{ $note->creator }}</small>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12 text-muted">
                            No notes yet.
                        </div>
                        @endforelse
                    </div>
                </div>


            </div>

            @if(Auth::user())
            <div class="d-flex justify-content-between m-4">
                <button onclick="printWarranty()" class="btn btn-primary">Print Detail</button>
                <button onclick="printcode()" class="btn btn-primary">Print QR & Barcode</button>
            </div>
            @endif



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
            Swal.fire({
                title: 'Pilih Jenis Cetak',
                input: 'radio',
                inputOptions: {
                    qrcode: 'QR Code saja',
                    barcode: 'Barcode saja',
                    both: 'QR & Barcode'
                },
                inputValidator: (value) => {
                    if (!value) {
                        return 'Silakan pilih salah satu opsi!'
                    }
                },
                showCancelButton: true,
                confirmButtonText: 'Cetak',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    const id = "{{ $item->id }}";
                    let url = `{{ route('find.print') }}?idArr[]=${id}`;

                    if (result.value === 'qrcode') {
                        url += `&qrcode=1`;
                    } else if (result.value === 'barcode') {
                        url += `&barcode=1`;
                    } else if (result.value === 'both') {
                        url += `&barcode=1&qrcode=1`;
                    }

                    window.open(url, '_blank');
                }
            });
        }
    </script>

</x-app-layout>