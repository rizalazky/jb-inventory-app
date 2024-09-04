<x-app-layout>
    <x-slot name="header">   
            {{ __('Configuration') }}
    </x-slot>

    <div class="container-fluid">
        <form method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card">
                
                <div class="card-body">
                    <input type="hidden" value="{{ $data->id ?? '' }}" name="id">

                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Toko</label>
                        <input type="text" class="form-control" id="name" value="{{ $data->name ?? '' }}" name="name">
                        @error('name') <p class="text-danger">{{ $message }}</p> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="phone" value="{{ $data->phone ?? '' }}" name="phone">
                        @error('phone') <p class="text-danger">{{ $message }}</p> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Logo</label>
                        @if(isset($data->logo))
                            <img src="{{ asset('storage/uploads/logos/' . $data->logo) }}" alt="Current Logo" width="100">
                        @endif
                        <input type="file" class="form-control-file mt-3" id="logo" value="{{ $data->logo ?? '' }}" name="logo">
                        @error('logo') <p class="text-danger">{{ $message }}</p> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Alamat Toko</label>
                        <textarea name="address" class="form-control" id="">{{ $data->address ?? '' }}</textarea>
                        @error('address') <p class="text-danger">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
