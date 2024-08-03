<x-app-layout>
    <x-slot name="header">   
            {{ __('Manage Customers') }}
    </x-slot>

    <div class="container-fluid">
        <form method="POST">
            @method('PUT')
            @csrf
            <div class="card">
                <div class="card-header">
                {{ __('Update Customer') }}
                </div>
                <div class="card-body">
                    <input type="hidden" value="{{ $customer->id }}" name="id">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" value="{{ $customer->name }}" name="name">
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Nomer HP</label>
                        <input type="phone" class="form-control" id="phone" value="{{ $customer->phone }}" name="phone">
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Alamat</label>
                        <textarea type="phone" class="form-control" id="address" name="address">{{ $customer->address }}</textarea>
                    </div>
                    
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
