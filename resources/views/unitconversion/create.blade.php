<x-app-layout>
    <x-slot name="header">   
            {{ __('Manage Products') }}
    </x-slot>

    <div class="container-fluid">
        <form method="POST">
            @csrf
            <div class="card">
                <div class="card-header">
                {{ __('Add Product') }}
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="mb-3 col-6">
                            <label for="name" class="form-label">Kode Produk/Barcode</label>
                            <input type="text" class="form-control" id="code" name="code">
                            @error('code') <p class="text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div class="mb-3 col-6">
                            <label for="name" class="form-label">Kategori Produk</label>
                            <select name="category_id" class="form-control" id="role">
                                <option value="">-- Pilih Kategori Produk --</option>
                                @foreach ($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id') <p class="text-danger">{{ $message }}</p> @enderror
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="mb-3 col-6">
                            <label for="name" class="form-label">Nama Produk</label>
                            <input type="text" class="form-control" id="name" name="name">
                            @error('name') <p class="text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div class="mb-3 col-6">
                            <label for="name" class="form-label">Stok Awal</label>
                            <input type="number" class="form-control" id="stock" name="stock">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Description</label>
                        <textarea type="text" class="form-control" id="description" name="description"></textarea>
                    </div>
                    
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
