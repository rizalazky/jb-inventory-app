<x-app-layout>
    <x-slot name="header">   
            {{ __('Manage Product Categories') }}
    </x-slot>

    <div class="container-fluid">
        <form method="POST">
            @method('PUT')
            @csrf
            <div class="card">
                <div class="card-header">
                {{ __('Update Product Category') }}
                </div>
                <div class="card-body">
                    <input type="hidden" value="{{ $categoryproduct->id }}" name="id">

                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" value="{{ $categoryproduct->name }}" name="name">
                        @error('name') <p class="text-danger">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
