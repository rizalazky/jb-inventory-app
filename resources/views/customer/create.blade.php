<x-app-layout>
    <x-slot name="header">   
            {{ __('Manage Users') }}
    </x-slot>

    <div class="container-fluid">
        <form method="POST">
            @csrf
            <div class="card">
                <div class="card-header">
                {{ __('Add customer') }}
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name">
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Nomer HP</label>
                        <input type="number" class="form-control" id="phone" name="phone">
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Alamat</label>
                        <textarea name="address" id="address" class="form-control"></textarea>
                    </div>
                    
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
