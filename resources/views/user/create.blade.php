<x-app-layout>
    <x-slot name="header">   
            {{ __('Manage Users') }}
    </x-slot>

    <div class="container-fluid">
        <form method="POST">
            @csrf
            <div class="card">
                <div class="card-header">
                {{ __('Add User') }}
                </div>
                <div class="card-body">
            
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email">
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name">
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select name="role" class="form-control" id="role">
                        @foreach ($roles as $role)
                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                        @endforeach
                        </select>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
