<x-app-layout>

    <x-slot name="header">

        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">

            {{ __('Detail') }}

        </h2>

    </x-slot>



    <div class="container py-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h2 class="h4 mb-4">{{ isset($user) ? 'Edit User' : 'Add New User' }}</h2>
                <form method="POST">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" value="{{ isset($user) ? $user->name : '' }}" id="name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" name="email" value="{{ isset($user) ? $user->email : '' }}" id="email" class="form-control" required>

                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" name="phone" value="{{ isset($user) ? $user->phone : '' }}" id="phone" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="role" class="form-label">Role</label>
                            <select name="role" id="role" class="form-control select2" required></select>
                        </div>
                        @if(!isset($user))
                        <div class="col-md-6">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                        </div>
                        @endif
                    </div>
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <script>
        var currentRoleId = {{ isset($user) ? $user-> role_id : 'null' }};

        $(document).ready(function() {
            $('#role').select2({
                placeholder: 'Pilih Role',
                allowClear: true
            });


            $.ajax({
                url: '{{ route('roles') }}',
                method: 'GET',
                success: function(data) {
                    $('#role').empty();
                    $.each(data, function(index, role) {
                        const selected = currentRoleId === role.id ? 'selected' : '';
                        $('#role').append('<option value="' + role.id + '" ' + selected + '>' + role.name + '</option>');
                    });

                    // Refresh Select2 setelah append
                    $('#role').trigger('change');
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching roles:', error);
                }
            });
        });
    </script>


</x-app-layout>