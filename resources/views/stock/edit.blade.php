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
                    <input type="hidden" value="{{ $user->id }}" name="id">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" value="{{ $user->email }}" name="email">
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" value="{{ $user->name }}" name="name">
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select name="role" class="form-control" id="role">
                        <option>-- Pilih Role --</option>
                        @foreach ($roles as $role)
                            @if($user->roles->isNotEmpty() && $user->roles->first()->name == $role->name)
                                <option value="{{ $role->name }}" selected>{{ $role->name }}</option>
                            @else
                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                            @endif
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
