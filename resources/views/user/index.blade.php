<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('User List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <a href="{{ route('role') }}" class="btn btn-outline-primary">Manage Roles</a>
                        <a href="{{ route('user.create') }}" class="btn btn-primary">+ Add User</a>
                    </div>

                    <div class="table-responsive">
                        <table id="userTable" class="table table-bordered table-hover align-middle">
                            <thead class="table-dark text-center">
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th style="width: 230px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $i)
                                <tr>
                                    <td>{{ $i->name }}</td>
                                    <td>{{ $i->email }}</td>
                                    <td>{{ $i->role->name }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('user.edit',['id' => $i->id]) }}" class="btn btn-sm btn-primary"><i class="bi bi-pencil"></i></a>
                                        <a onclick="return confirm('Are you sure?')" href="{{ route('user.delete',['id' => $i->id]) }}" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></a>
                                        <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#changePasswordModal" data-user-id="{{ $i->id }}">
                                            <i class="bi bi-key"></i>
                                        </button>
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

    {{-- Modal Change Password --}}
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" id="passwordChangeForm">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="password" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save changes</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        var passwordForm = document.getElementById('passwordChangeForm');
        var passwordModal = document.getElementById('changePasswordModal');

        passwordModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const userId = button.getAttribute('data-user-id');
            passwordForm.setAttribute('action', `/user/edit-password/${userId}`);
        });
    </script>
</x-app-layout>