<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="mb-0">Warranty List</h4>
                        <div class="btn-group">
                            <button class="btn btn-outline-primary" onclick="printSelectedLabels()">🖨 Cetak</button>
                            <button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#importModal">⬆️ Import</button>
                            <button class="btn btn-outline-success" onclick="eksportSelectedLabels()">⬇️ Export</button>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="warrantyTable" class="table table-hover align-middle table-bordered">
                            <thead class="table-dark text-center">
                                <tr>
                                    <th><input type="checkbox" id="select-all" onclick="toggleSelectAll(this)"></th>
                                    <th>Warranty Code</th>
                                    <th>Serial Number</th>
                                    <th>Customer</th>
                                    <th>PO Number</th>
                                    <th>Expired Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $i)
                                <tr>
                                    <td class="text-center">
                                        <input type="checkbox" class="checkbox-item" value="{{ $i->id }}">
                                    </td>
                                    <td>{{ $i->warranty_code }}</td>
                                    <td>{{ $i->serial_number }}</td>
                                    <td>{{ $i->customer }}</td>
                                    <td>{{ $i->po_number }}</td>
                                    <td>{{ $i->expired_date }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('find.detail',['id' => $i->id]) }}" class="btn btn-sm btn-info">Detail</a>
                                        <a href="{{ route('find.delete',['id' => $i->id]) }}" onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">Delete</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal --}}
    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="importModalLabel">Import Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <a href="https://docs.google.com/spreadsheets/d/1gcGYhWNr6hE7t6gh6UmLC-9NlpSS2gJ9M_e-Po8k8-g/edit?usp=sharing" target="_blank" class="btn btn-info mb-3">View Template</a>
                        <input type="file" name="file" class="form-control" required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Scripts --}}
    <script>
        function toggleSelectAll(source) {
            const checkboxes = document.querySelectorAll('.checkbox-item');
            checkboxes.forEach(checkbox => checkbox.checked = source.checked);
        }

        function printSelectedLabels() {
            const selected = Array.from(document.querySelectorAll('.checkbox-item:checked'))
                .map(cb => cb.value);

            if (selected.length === 0) {
                alert("Please select at least one item.");
                return;
            }

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
                    let url = `{{ route('find.print') }}?` + selected.map(id => `idArr[]=${id}`).join('&');
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

        function eksportSelectedLabels() {
            const selected = Array.from(document.querySelectorAll('.checkbox-item:checked'))
                .map(cb => cb.value);

            if (selected.length === 0) {
                alert("Please select at least one item.");
                return;
            }

            const url = `{{ route('find.eksport') }}?` + selected.map(id => `idArr[]=${id}`).join('&');
            window.open(url, '_blank');
        }
    </script>
</x-app-layout>