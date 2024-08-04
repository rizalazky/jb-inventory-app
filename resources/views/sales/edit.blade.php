<x-app-layout>
    <x-slot name="header">   
            {{ __('Manage Users') }}
    </x-slot>

    <div class="container-fluid">
        <form method="POST">
            @method('PUT')
            @csrf
            <div class="card">
                <div class="card-header">
                {{ __('Update User') }}
                </div>
                <div class="card-body">
                    <input type="hidden" value="{{ $supplier->id }}" name="id">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="name" value="{{ $supplier->name }}" name="name">
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Nomer hp</label>
                        <input type="number" class="form-control"value="{{ $supplier->phone }}" id="phone" name="phone">
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Alamat</label>
                        <textarea name="address" class="form-control" id="">{{ $supplier->address }}</textarea>
                    </div>
                     <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea name="description" class="form-control" id="">{{ $supplier->description }}</textarea>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
