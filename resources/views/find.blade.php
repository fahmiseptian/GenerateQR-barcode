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
                    <h4 class="mb-4">Warranty List</h4>
                    <div class="mb-3">
                        <button class="btn btn-success" onclick="printSelectedLabels()">Print Selected</button>
                    </div>
                    <div class="table-responsive">
                        <table id="warrantyTable" class="table table-bordered table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">
                                        <input type="checkbox" id="select-all" onclick="toggleSelectAll(this)">
                                    </th>
                                    <th scope="col">Warranty Code</th>
                                    <th scope="col">Serial Number</th>
                                    <th scope="col">Customer</th>
                                    <th scope="col">PO Number</th>
                                    <th scope="col">Expired Date</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $i)
                                <tr>
                                    <td>
                                        <input type="checkbox" class="checkbox-item" value="{{ $i->id }}">
                                    </td>
                                    <td>{{ $i->warranty_code }}</td>
                                    <td>{{ $i->serial_number }}</td>
                                    <td>{{ $i->customer }}</td>
                                    <td>{{ $i->po_number }}</td>
                                    <td>{{ $i->expired_date }}</td>
                                    <td>
                                        <a href="{{ route('find.detail',['id' => $i->id]) }}" class="btn btn-primary btn-sm">Detail</a>
                                        <a onclick="return confirm('Are you sure?')" href="{{ route('find.delete',['id' => $i->id]) }}" class="btn btn-danger btn-sm">Delete</a>
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

    <script>
        // Toggle Select All
        function toggleSelectAll(source) {
            const checkboxes = document.querySelectorAll('.checkbox-item');
            checkboxes.forEach(checkbox => checkbox.checked = source.checked);
        }

        // Print Selected Labels
        function printSelectedLabels() {
            const selected = Array.from(document.querySelectorAll('.checkbox-item:checked'))
                .map(checkbox => checkbox.value);

            if (selected.length === 0) {
                alert("Please select at least one item.");
                return;
            }

            // Redirect to Print Page with selected IDs
            const url = `{{ route('find.print') }}?` + selected.map(id => `idArr[]=${id}`).join('&');
            window.open(url, '_blank');
        }
    </script>
</x-app-layout>