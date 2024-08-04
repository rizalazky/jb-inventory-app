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
                    <div class="row">
                        <div class="mb-3 col-6 col-xs-12">
                            <label for="name" class="form-label">Nama</label>
                            <input disabled type="text" class="form-control" id="name" value="{{ $supplier->name }}" name="name">
                        </div>
                        <div class="mb-3 col-6 col-xs-12">
                            <label for="phone" class="form-label">Nomer hp</label>
                            <input disabled type="number" class="form-control"value="{{ $supplier->phone }}" id="phone" name="phone">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Alamat</label>
                        <textarea disabled name="address" class="form-control" id="">{{ $supplier->address }}</textarea>
                    </div>
                     <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea disabled name="description" class="form-control" id="">{{ $supplier->description }}</textarea>
                    </div>
                </div>
                <!-- <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div> -->
            </div>
        </form>
        

        <div class="card">
            <div class="card-header">
                LIST SALES
            </div>
            <div class="card-body">
                <div>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Add Sales
                    </button>
                </div>
                {{ $dataTable->table() }}
            </div>
            <div class="card-footer">

            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5" id="exampleModalLabel">Tambah Sales</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" id="form-sales" action="/sales/create">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" value="{{ $supplier->id }}" name="supplier_id">
                        <input type="hidden" name="id" id="sales-id">
                        <div class="row">
                            <div class="mb-3 col-6 col-xs-12">
                                <label for="name" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="sales-name" name="name">
                            </div>
                            <div class="mb-3 col-6 col-xs-12">
                                <label for="phone" class="form-label">Nomer hp</label>
                                <input type="number" class="form-control" id="sales-phone" name="phone">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Alamat</label>
                            <textarea name="address" class="form-control" id="sales-address"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('js')
        {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    @endpush
</x-app-layout>
