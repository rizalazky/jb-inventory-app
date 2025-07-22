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
                        <input type="text" class="form-control" id="name" @disabled($role->name == 'Super-Admin') value="{{ $role->name }}" name="name">
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary" @disabled($role->name == 'Super-Admin')>Submit</button>
                </div>
            </div>
        </form>
    </div>

    @if($role->name == 'Super-Admin')
        <p class='text-center'>Access Granted for Super Admin</p>
    @else
        <div class="container-fluid d-flex flex-wrap gap-2 overflow-auto">
            @foreach($permissions as $menu => $sub_menus)
                <div class="card w-100">
                    <div class="card-header">
                        <form method="POST" action="/role/permission">
                            @method('PUT')
                            @csrf
                            <div class="custom-control custom-switch mb-0">
                                <input type="hidden" name="permission_name" value="{{ $menu }}">
                                <input type="hidden" name="role_id" value="{{ $role->id }}">
                                <input type="checkbox" class="custom-control-input" name="action" id="customSwitch1-{{ $menu }}" onchange="this.form.submit()" @checked($role->hasPermissionTo($menu))>
                                <label class="custom-control-label" for="customSwitch1-{{ $menu }}">{{ $menu }}</label>
                            </div>
                        </form>
                    </div>
                    <div class="card-body row">
                        @foreach($sub_menus as $sub_menu => $actions)
                            <div class="mb-3 col">
                                <label class="form-label">{{ $sub_menu }}</label>
                                <div class="form-check">
                                    @foreach($actions as $key => $action)
                                        <form method="POST" action="/role/permission">
                                            @method('PUT')
                                            @csrf
                                            <div class="custom-control custom-switch">
                                                <input type="hidden" name="permission_name" value="{{ $action->name }}">
                                                <input type="hidden" name="role_id" value="{{ $role->id }}">
                                                <input type="checkbox" class="custom-control-input" name="action" id="customSwitch1-{{ $action->id }}" onchange="this.form.submit()" @checked($role->hasPermissionTo($action->name))>
                                                <label class="custom-control-label" for="customSwitch1-{{ $action->id }}">{{ explode(' ',$action->name )[2] }}</label>
                                            </div>
                                        </form>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</x-app-layout>
