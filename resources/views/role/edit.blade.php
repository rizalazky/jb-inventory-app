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

    <div class="container-fluid d-flex flex-wrap gap-2 overflow-auto">
        @foreach($permissions as $permission)
            <div class="card" style="min-width:250px;">
                <div class="card-header">
                {{ explode(' ', $permission[0]->name, 2)[1] ?? $permission[0]->name }}
                </div>
                <div class="card-body">
                    
                    @foreach($permission as $per)
                    <form method="POST" action="/role/permission">
                        @method('PUT')
                        @csrf
                        <div class="custom-control custom-switch">
                            <input type="hidden" name="permission_name" value="{{ $per->name }}">
                            <input type="hidden" name="role_id" value="{{ $role->id }}">
                            <input type="checkbox" class="custom-control-input" name="action" id="customSwitch1-{{ $per->id }}" onchange="this.form.submit()" @checked($role->hasPermissionTo($per->name))>
                            <label class="custom-control-label" for="customSwitch1-{{ $per->id }}">{{ $per->name }}</label>
                        </div>
                    </form>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</x-app-layout>
