<x-app-layout>
    <x-slot name="header">   
            {{ __('Manage Products') }}
    </x-slot>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <form method="POST">
                    @method('PUT')
                    @csrf
                    <div class="card">
                        <div class="card-header">
                        {{ __('Edit Product') }}
                        </div>
                        <div class="card-body">
                            <input type="hidden" name="id" value="{{ $product->id }}">
                            <div class="row">
                                <div class="mb-3 col-6">
                                    <label for="name" class="form-label">Kode Produk/Barcode</label>
                                    <input type="text" class="form-control" id="code" value="{{ $product->code }}" name="code">
                                    @error('code') <p class="text-danger">{{ $message }}</p> @enderror
                                </div>
                                <div class="mb-3 col-6">
                                    <label for="name" class="form-label">Kategori Produk</label>
                                    <select name="category_id" class="form-control" id="role">
                                        <option value="">-- Pilih Kategori Produk --</option>
                                        @foreach ($categories as $cat)
                                            @if($cat->id == $product->id)
                                                <option value="{{ $cat->id }}" selected>{{ $cat->name }}</option>
                                            @else
                                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @error('category_id') <p class="text-danger">{{ $message }}</p> @enderror
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="mb-3 col-6">
                                    <label for="name" class="form-label">Nama Produk</label>
                                    <input type="text" class="form-control" id="name" value="{{ $product->name }}" name="name">
                                    @error('name') <p class="text-danger">{{ $message }}</p> @enderror
                                </div>
                                <div class="mb-3 col-6">
                                    <label for="name" class="form-label">Stok</label>
                                    <input type="number" class="form-control" disabled id="stock" value="{{ $product->stock }}" name="stock">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">Description</label>
                                <textarea type="text" class="form-control" id="description" name="description">{{ $product->description }}</textarea>
                            </div>
                            
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
                
            </div>
            <div class="col-md-6">
            <table class="table table-striped">
                <thead>
                    
                </thead>
                <tbody>

                </tbody>
            </table>
            </div>
        </div>
    </div>
</x-app-layout>
