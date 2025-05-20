<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Form Note') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="mb-4">Form note</h4>
                    <form method="POST">
                        @csrf
                        <!-- Hidden field untuk items_id -->
                        <input type="hidden" name="items_id" value="{{ $item->id }}">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" name="title" id="title" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="creator" class="form-label">Creator</label>
                            <input type="text" name="creator" id="creator" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="content" class="form-label">Note</label>
                            <textarea name="content" id="content" class="form-control" rows="5"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>