<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Group') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container">
            <div class="card shadow-sm">
                <div class="card-body">
                    <a href="{{ route('group.add') }}">
                        <div class="btn btn-outline-primary mb-3"> Add New Group</div>
                    </a>
                    <div class="table-responsive">
                        <table id="groupTable" class="table table-hover align-middle table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Created</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                @if(!empty($groups) && count($groups) > 0)
                                @foreach($groups as $group)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $group->name }}</td>
                                    <td>{{ $group->created_at->format('d-m-y') }}</td>
                                    <td>
                                        <a href="{{ route('group.detail',['id' => $group->id]) }}" class="btn btn-sm btn-info">Detail</a>
                                        <a href="{{ route('group.delete',['id' => $group->id]) }}" onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">Delete</a>
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="3">Data is empty</td>
                                </tr>
                                @endif
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>