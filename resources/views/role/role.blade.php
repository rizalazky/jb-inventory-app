<x-app-layout>
    <x-slot name="header">   
            {{ __('Manage Roles') }}
    </x-slot>

    <div class="container-fluid">
        @if (session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
        <div class="card">
            <!-- <div class="card-header"></div> -->
            <div class="card-body">
                {{ $dataTable->table() }}
            </div>
        </div>
    </div>

    @push('js')
        {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    @endpush
</x-app-layout>
