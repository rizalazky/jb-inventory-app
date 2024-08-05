<x-app-layout>
    <x-slot name="header">   
            {{ __('Manage Product Unit') }}
    </x-slot>

    <div class="container-fluid">
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