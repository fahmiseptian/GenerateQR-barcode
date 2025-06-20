<x-app-layout>
    <!-- CSS Tom Select -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __( isset($data) ? 'Edit Group' : 'New Group' ) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="row">
                        <form  method="POST">
                            @csrf
                            <div class="col-md-8">
                                <label for="name" class="form-label">Group Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ isset($data) && !old('name') ? $data->name : old('name') }}"
                                    placeholder="Enter Group Name" />
                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                            </div>
                        </form>
                        @if(!empty($data))
                        <h2 class="mt-5">List Product</h2>
                        <div class="text-end">
                            <a href="#" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#addProductModal">
                                Add Product
                            </a>
                        </div>
                        <div class="table-responsive mt-3">
                            <table id="warrantyTable" class="table table-hover align-middle table-bordered ">
                                <thead class="table-dark text-center">
                                    <tr>
                                        <th>Warranty Code</th>
                                        <th>Serial Number</th>
                                        <th>Customer</th>
                                        <th>PO Number</th>
                                        <th>Expired Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data->grupitem as $i => $gi)
                                    <tr>
                                        <td>{{ $gi->item->warranty_code }}</td>
                                        <td>{{ $gi->item->serial_number }}</td>
                                        <td>{{ $gi->item->customer }}</td>
                                        <td>{{ $gi->item->po_number }}</td>
                                        <td>{{ $gi->item->expired_date }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('find.detail',['id' => $gi->item->id]) }}" class="btn btn-sm btn-info">Detail</a>
                                            <a href="{{ route('group.detail.delete',['id' =>$data->id,'idgrupitem' => $gi->id]) }}" onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">Delete</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(!empty($items))
    <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProductModalLabel">Add Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <select id="product-select" name="product" class="form-select form-select-lg mb-3">
                            @foreach($items as $i)
                            <option value="{{ $i->id }}">{{ $i->warranty_code }}</option>
                            @endforeach
                        </select>
                        <input type="hidden" id="group-id" value="{{ $data->id }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="save-product-btn" class="btn btn-primary">Save Product</button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <script>
        new TomSelect('#product-select', {
            create: false, // jika true, user bisa mengetik dan buat opsi baru
            sortField: {
                field: "text",
                direction: "asc"
            }
        });
    </script>
    <script>
        $('#save-product-btn').click(function() {
            const itemId = $('#product-select').val();
            const groupId = $('#group-id').val();

            $.ajax({
                url: '{{ route("group.detail.store") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    group_id: groupId,
                    item_id: itemId
                },
                success: function(response) {
                    $('#addProductModal').modal('hide');
                    location.reload();
                },
                error: function(xhr) {
                    Swal.fire('Error!', 'Terjadi kesalahan saat menyimpan data.', 'error');
                }
            });
        });
    </script>


</x-app-layout>