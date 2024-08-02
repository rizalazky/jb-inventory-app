<x-app-layout>
    <x-slot name="header">   
            {{ __('Manage Roles') }}
    </x-slot>

    <div class="container-fluid">
        <form method="POST">
            @method('PUT')
            @csrf
            <div class="card">
                <div class="card-header">
                {{ __('Update Role') }}
                </div>
                <div class="card-body">
                    <input type="hidden" value="{{ $role->id }}" name="id">
                    <div class="mb-3">
                        <label for="name" class="form-label">Role Name</label>
                        <input type="text" class="form-control" id="name" value="{{ $role->name }}" name="name">
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
